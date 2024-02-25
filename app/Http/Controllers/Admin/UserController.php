<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Facade\MessagesFactory;
use App\Facade\NavigateFactory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Admin\CompanyController;
use App\Actions\Fortify\UpdateUserProfileInformation;

class UserController extends Controller
{
    use PasswordValidationRules;
    private CompanyController $company_controller;
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->company_controller = new CompanyController();
    }
    public function index(Request $request)
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Usuários')
            ->setLink('Lista');
        $company_id = $request->company_id ?? 0;
        if ($company_id) { //filtradno cliente por empresa
            $users = User::with(['company' => fn ($query) => $query->select('id', 'name')])->whereHas('company', function ($query) use ($company_id) {
                $query->where('id', $company_id);
            })->orderBy('responsible', 'desc')->paginate(10);
        } else {
            $users = User::with(['company' => fn ($query) => $query->select('id', 'name')])->orderBy('id', 'desc')->paginate(10);
        }

        return Inertia::render('Admin/User/List', [
            'breadcrumb' => $breadcrumb->generate(),
            'users' => $users,
            'companies' => Company::select('id', 'name')->cursor()
        ]);
    }
    public function createView(Request $request)
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Usuários')
            ->setLink('Lista', route: route('adm.user.index'))
            ->setLink('Novo');
        $responsible = filter_var($request->responsible ?? false, FILTER_VALIDATE_BOOLEAN);
        $companies = null;
        if ($responsible) { //caso usuario resposanvel, busca empresas sem responsaveis
            $companies = Company::staticCompaniesWithoutResponsible();
        } else {
            $companies = Company::staticCompaniesWithResponsible();
        }
        return Inertia::render('Admin/User/Create', [
            'breadcrumb' => $breadcrumb->generate(),
            'companies' => $companies,
            'payment_plans' => $this->company_controller->getPaymentPlans(),
            'filter' => [
                'responsible' => $responsible
            ],
            'images' => [
                'company' => asset('img/company-94.png')
            ]
        ]);
    }
    public function editView(User $user)
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Usuários')
            ->setLink('Lista', route: route('adm.user.index'))
            ->setLink('Editar');

        $companies = Company::staticCompaniesWithResponsible();
        return Inertia::render('Admin/User/Edit', [
            'breadcrumb' => $breadcrumb->generate(),
            'companies' => $companies,
            'user' => $user,
            'companies' => $companies,
        ]);
    }

    /**===================================METODOS ROTAS=================================== */
    public function create(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
            'company_id' => $request->company_id,
            'responsible' => $request->responsible
        ];
        Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'company_id' => ['required', 'bigger_then'],
            'password' => $this->passwordRules(),
        ], [], [
            'company_id' => 'empresa'
        ])->validate();
        try {
            DB::transaction(function () use ($request, $data) {
                User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'company_id' => $data['company_id'],
                    'responsible' => $data['responsible'],
                    'email_verified_at' => now(),
                ]);
                $message = $request->responsible ? 'Usuário responsável cadastrado com sucesso' : 'Usuário afiliado cadastrado com sucesso';
                MessagesFactory::toast()
                    ->success($message)
                    ->generate();
            });
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
    public function update(Request $request)
    {
        $data = $request->all();
        Validator::make(['id' => $request->id, ...$data], [
            'id' => ['required', 'integer', 'bigger_then'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($request->id)],
            'company_id' => ['required', 'bigger_then'],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'password' => $this->passwordRulesExists()
        ], [], [
            'company_id' => 'empresa'
        ])->validate();
        try {
            DB::transaction(function () use ($request, $data) {
                $toast = MessagesFactory::toast();
                $user = User::find($request->id);
                if (empty($data['password'])) {
                    unset($data['password'], $data['password_confirmation']);
                } else {
                    unset($data['password_confirmation']);
                    $data['password'] = Hash::make($data['password']);
                    $user->update([
                        'password' => $data['password'],
                    ]);
                    $toast->success('Senha atualizada com sucesso');
                }
                $user_action = new UpdateUserProfileInformation();
                $user_action->update($user, $data, false);
                $toast->success('Registro atualizado com sucesso')
                    ->generate();
            });
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
    public function delete(User $user)
    {
        try {
            DB::transaction(function () use ($user) {
                $toast = MessagesFactory::toast();
                $count_users = $user->company->wcount('users');
                if ($count_users == 1 && $user->responsible) { //usuario pode ser deletado e empresa desativada
                    MessagesFactory::alertSwal()
                        ->deleteQuestion('Caso usuário deletado a empresa será desativada, pois o mesmo é o único usuário e responsável da empresa, deseja continuar?')
                        ->generate();
                } else if ($count_users > 1 && $user->responsible) { //usuario não pode ser deletado ate vc escolher outro responsavel ou deletar todos responsaveis
                    $toast->warning('Usuário não pode ser deletado ate ser escolhido outro responsável ou deletar todos integrantes da empresa');
                } else { //pode ser deletado
                    $user->delete();
                }
                $toast->generate();
            });
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }

    public function deleteAndDisableCompany(User $user)
    {
        try {
            DB::transaction(function () use ($user) {
                $user->company->update(['active' => false]);
                $user->delete();
                MessagesFactory::toast()
                    ->success('Usuário deletado')
                    ->success("Empresa: {$user->company->name} desativada")->generate();
            });
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
}
