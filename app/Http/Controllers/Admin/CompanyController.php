<?php

namespace App\Http\Controllers\Admin;

use App\Facade\MessagesFactory;
use Closure;
use Inertia\Inertia;
use App\Models\Company;
use App\Models\PaymentPlan;
use App\Trait\UploadStorage;
use Illuminate\Http\Request;
use App\Facade\NavigateFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\File;

class CompanyController extends Controller
{
    use UploadStorage;
    public array $company_paths = [
        'brand_logo' => 'company/brand_logo/',
    ];
    public function index()
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Empresa')
            ->setLink('Lista');
        $companys = Company::with('paymentPlan')->paginate(10);
        return Inertia::render('Admin/Company/List', [
            'breadcrumb' => $breadcrumb->generate(),
            'companys' => $companys
        ]);
    }
    public function createView()
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Empresa')
            ->setLink('Lista', route: route('company.index'))
            ->setLink('Nova');
        return Inertia::render('Admin/Company/Create', [
            'breadcrumb' => $breadcrumb->generate(),
            'payment_plans' => PaymentPlan::select('id', 'title')->get(),
            'images' => [
                'company' => asset('img/company-94.png')
            ]
        ]);
    }
    public function editView(Company $company)
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Empresa')
            ->setLink('Lista', route: route('company.index'))
            ->setLink('Editar');
        return Inertia::render('Admin/Company/Edit', [
            'breadcrumb' => $breadcrumb->generate(),
            'payment_plans' => PaymentPlan::select('id', 'title')->get(),
            'company' => $company,
            'images' => [
                'company' => asset('img/company-94.png')
            ]
        ]);
    }
    /**===================================METODOS=================================== */
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:5'],
            'surname' => ['required'],
            'cnpj' => ['required'],
            'photo' => [
                'required', 'file', File::types('jpg,jpeg,png')->max('2mb')
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
        // $request->validate([
        //     'name' => ['required', 'min:5'],
        //     'surname' => ['required'],
        //     'cnpj' => ['required'],
        //     'photo' => [
        //         'required', 'file', File::types('jpg,jpeg,png')->max('2mb')
        //     ],
        //     'payment_plan' => [
        //         'required', 'integer',
        //         function (string $attribute, mixed $value, Closure $fail) {
        //             if ($value <= 0) {
        //                 $fail("O plano de pagamento, precisa ser um valor válido.");
        //             }
        //         }
        //     ]
        // ], [], [
        //     'name' => 'razão social',
        //     'surname' => 'apelido',
        //     'photo' => 'foto',
        // ]);

        try {
            DB::transaction(function () use ($request) {
                // $company = Company::where('id', $request->id)->update([
                //     'name' => $request->name,
                //     'surname' => $request->surname,
                //     'cnpj' => $request->cnpj,
                //     'payment_plan_id' => $request->payment_plan,
                // ]);
                $this->deleteImage(new Request());
                //verficar se tem nova imagem a ser colocada
                MessagesFactory::toast()
                ->create('Sucesso', 'Empresa atualizada com sucesso', 'success')
                ->create('Sucesso', 'Foto deletada com sucesso', 'success')
                ->generate();
            });
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
                //verficar se tem arquivo de iamgem para remover
                //remover arquivo de imagem
                // Company::where('id', $request->id)->update([
                //     'logo' => null
                // ]);
                MessagesFactory::toast()
                ->create('Sucesso', 'Imagem deletada com sucesso', 'success')
                ->generate();
            });
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
}
