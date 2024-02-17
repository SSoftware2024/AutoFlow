<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Facade\MessagesFactory;
use App\Facade\NavigateFactory;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\Facades\Hash;

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
    public function index()
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Usuários')
            ->setLink('Lista');
        $users = User::with(['company' => function ($query) {
            $query->select('id', 'name');
        }])->get();
        return Inertia::render('Admin/User/List', [
            'breadcrumb' => $breadcrumb->generate(),
            'users' => $users
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
            $companies = Company::companiesWithoutResponsible();
        } else {
            $companies = Company::companiesWithResponsible();
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

        $companies = Company::companiesWithResponsible();
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
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ], [], [
            'company_id' => 'empresa'
        ])->validate();
        try {
            $user = new CreateNewUser();
            $user->create($data, false);
            $message = $request->responsible ? 'Usuário responsável cadastrado com sucesso' : 'Usuário afiliado cadastrado com sucesso';
            MessagesFactory::toast()
                ->success($message)
                ->generate();
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
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
}
