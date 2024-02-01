<?php

namespace App\Http\Controllers\Admin;

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
    public function createView()
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Empresa')
            ->setLink('Lista')
            ->setLink('Nova');
        return Inertia::render('Admin/Company/Create', [
            'breadcrumb' => $breadcrumb->generate(),
            'payment_plans' => PaymentPlan::select('id', 'title')->get(),
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
                    $company->logo = $this->uploadStorage($photo, $this->company_paths['brand_logo'],'brand', [200,200], true);
                    $company->save();
                }
            });
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
}
