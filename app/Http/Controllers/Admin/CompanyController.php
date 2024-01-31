<?php

namespace App\Http\Controllers\Admin;

use Closure;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Facade\NavigateFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\File;
use App\Services\Final\Admin\PaymentPlan;
use Intervention\Image\Laravel\Facades\Image;

class CompanyController extends Controller
{
    public function createView()
    {

        $img = Image::read(file_get_contents(public_path('img/company-94.png')));
        $img->resize(10,10)->save("img/teste-cp.png");
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Empresa')
            ->setLink('Lista')
            ->setLink('Nova');
        $paymentPlan =  new PaymentPlan();
        return Inertia::render('Admin/Company/Create', [
            'breadcrumb' => $breadcrumb->generate(),
            'payment_plans' => $paymentPlan->getDataSelect(),
            'images' => [
                'company' => asset('img/company-94.png')
            ]
        ]);
    }
    /**===================================METODOS=================================== */
    public function create(Request $request)
    {
        dd($request->content);
        DB::transaction(function () use ($request) {
            try {
                $content = (object) $request->content;
                if ($request->validateContent([
                    'name' => ['required', 'min:5'],
                    'surname' => ['required'],
                    'cnpj' => ['required'],
                    'file' => [
                        'required',
                        File::types(['jpg', 'jpeg', 'png'])->max('12mb')
                    ]
                ], [], [
                    'name' => 'razão social'
                ])) {
                    return;
                }
            } catch (\Exception $e) {
                $errors = new MessageBag();
                $errors->add('catch', $e->getMessage());
                return redirect()->back()->withErrors($errors);
            }
        });
    }
}
