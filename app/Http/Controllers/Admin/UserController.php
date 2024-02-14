<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Facade\MessagesFactory;
use App\Facade\NavigateFactory;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;

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
        return Inertia::render('Admin/User/List', [
            'breadcrumb' => $breadcrumb->generate(),
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
        if ($responsible) {
            $companies = Company::select('id', 'name')->withCount([
                'users' => function (Builder $query) {
                    $query->where('responsible', 1);
                }
            ])->get()->map(function ($company) {
                if ($company->users_count == 0) {
                    return $company;
                }
            })->filter()->values();
        } else {
            $companies = Company::select('id', 'name')->whereHas('users', function ($query) {
                $query->where('responsible', 1);
            })->cursor();
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

    /**===================================METODOS=================================== */
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
            'company_id' => ['required','bigger_then'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ],[],[
            'company_id' => 'empresa'
        ])->validate();
        try {
            $user = new CreateNewUser();
            $user->create($data, false);
            $message = $request->responsible ? 'Usuário responsável cadastrado com sucesso':'Usuário afiliado cadastrado com sucesso';
            MessagesFactory::toast()
                ->success($message)
                ->generate();
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
}
