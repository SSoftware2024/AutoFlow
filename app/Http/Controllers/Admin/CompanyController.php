<?php

namespace App\Http\Controllers\Admin;

use Closure;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Company;
use App\Trait\UploadStorage;
use Illuminate\Http\Request;
use App\Facade\MessagesFactory;
use App\Facade\NavigateFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\File;
use  App\Models\Financial\PaymentPlan;;

use Illuminate\Database\Eloquent\Collection;

class CompanyController extends Controller
{
    use UploadStorage;
    private string $max_size_file = '1mb';
    public array $company_paths = [
        'brand_logo' => 'company/brand_logo/',
    ];
    public function index()
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Empresa')
            ->setLink('Lista');
        $companys = Company::with(['paymentPlan' => function ($query) {
            $query->select('id', 'title');
        }])->withCount('users')->paginate(10);
        return Inertia::render('Admin/Company/List', [
            'breadcrumb' => $breadcrumb->generate(),
            'companys' => $companys
        ]);
    }
    public function createView()
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Empresa')
            ->setLink('Lista', route: route('adm.company.index'))
            ->setLink('Nova');
        return Inertia::render('Admin/Company/Create', [
            'breadcrumb' => $breadcrumb->generate(),
            'payment_plans' => $this->getPaymentPlans(),
            'images' => [
                'company' => asset('img/company-94.png')
            ]
        ]);
    }
    public function editView(Company $company)
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Empresa')
            ->setLink('Lista', route: route('adm.company.index'))
            ->setLink('Editar');
        return Inertia::render('Admin/Company/Edit', [
            'breadcrumb' => $breadcrumb->generate(),
            'payment_plans' => $this->getPaymentPlans(),
            'company' => $company,
            'images' => [
                'company' => asset('img/company-94.png')
            ]
        ]);
    }
    public function listResponsiblesView(Company $company)
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Empresa')
            ->setLink('Lista', route: route('adm.company.index'))
            ->setLink('Controle responsável');
        ds($company);
        return Inertia::render('Admin/Company/ListResponsible', [
            'breadcrumb' => $breadcrumb->generate(),
            'images' => [
                'company' => asset('img/company-94.png')
            ],
            'company' => $company,
            'user_responsible' => $company?->getUserResponsible(),
            'users_company' => $company?->getUsersWithoutResponsible(),
            'companies' => Company::select('id', 'name')->cursor()
        ]);
    }
    /**===================================METODOS ROUTES=================================== */
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:5'],
            'surname' => ['required'],
            'cnpj' => ['required'],
            'photo' => [
                'required', 'file', File::types('jpg,jpeg,png')->max($this->max_size_file)
            ],
            'payment_plan' => [
                'required', 'integer',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value <= 0) {
                        $fail("O plano de pagamento, precisa ser um valor válido.");
                    }
                }
            ]
        ], [], [
            'name' => 'razão social',
            'surname' => 'apelido',
            'photo' => 'foto',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $company = Company::create([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'cnpj' => $request->cnpj,
                    'payment_plan_id' => $request->payment_plan,
                ]);
                if ($request->hasFile('photo')) {
                    $photo = $request->photo;
                    $company->logo = $this->uploadStorage($photo, $this->company_paths['brand_logo'], 'brand', [100, 100], true);
                    $company->save();
                }
            });
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:5'],
            'surname' => ['required'],
            'cnpj' => ['required'],
            'photo' => [
                'nullable', 'file', File::types('jpg,jpeg,png')->max($this->max_size_file)
            ],
            'payment_plan' => [
                'required', 'integer',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value <= 0) {
                        $fail("O plano de pagamento, precisa ser um valor válido.");
                    }
                }
            ]
        ], [], [
            'name' => 'razão social',
            'surname' => 'apelido',
            'photo' => 'foto',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $company = Company::find($request->id);
                $company->update([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'cnpj' => $request->cnpj,
                    'active' => $request->active,
                    'payment_plan_id' => $request->payment_plan,
                ]);
                if ($request->hasFile('photo')) {
                    $photo = $request->photo;
                    $this->deleteImage(new Request([
                        'id' => $request->id
                    ]));
                    $company->logo = $this->uploadStorage($photo, $this->company_paths['brand_logo'], 'brand', [100, 100], true);
                    $company->save();
                }
                MessagesFactory::toast()
                    ->success('Empresa atualizada com sucesso')
                    ->generate();
            });
            return redirect()->back();
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
    public function deleteImage(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $company = Company::find($request->id);
                $isDeleted = $this->deleteStorage($this->company_paths['brand_logo'], $company->logo);
                if ($isDeleted) {
                    $company->logo = null;
                    $company->save();
                    MessagesFactory::toast()
                        ->success('Imagem deletada com sucesso')
                        ->generate();
                }
                return redirect()->back();
            });
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        } catch (\Error $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
    public function delete(int $id = 0)
    {
        try {
            DB::transaction(function () use ($id) {
                $company = Company::where('id', $id)->select('id', 'logo')->first();
                $this->deleteStorage($this->company_paths['brand_logo'], $company->logo);
                $company->delete();
                MessagesFactory::toast()
                    ->success('Registro deletado com sucesso')
                    ->generate();
            });
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        } catch (\Error $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
    public function newResponsible(Request $request)
    {
        $request->validate([
            'new_responsible' => ['required', 'integer', 'bigger_then'],
            'old_responsible' => ['required', 'integer', 'bigger_then'],
        ]);
        try {
            DB::transaction(function () use ($request) {
                User::where('id', $request->old_responsible)->update([
                    'responsible' => false,
                ]);
                User::where('id', $request->new_responsible)->update([
                    'responsible' => true,
                ]);
                MessagesFactory::toast()
                    ->success('Operação concluída com sucesso')
                    ->generate();
            });
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        } catch (\Error $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
    /**===================================METODOS ROUTES AXIOS=================================== */
    /**===================================METODOS VARIADOS=================================== */
    public function getPaymentPlans(): Collection
    {
        return PaymentPlan::select('id', 'title')->get();
    }
}
