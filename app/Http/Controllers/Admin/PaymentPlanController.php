<?php

namespace App\Http\Controllers\Admin;

use Closure;
use Inertia\Inertia;
use App\Models\PaymentPlan;
use Illuminate\Http\Request;
use App\Facade\NavigateFactory;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PaymentPlanController extends Controller
{
    public function createView(Request $request)
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Plano de pagamento')
            ->setLink('Lista')
            ->setLink('Novo');
        return Inertia::render('Admin/PaymentPlan/Create', [
            'breadcrumb' => $breadcrumb->generate()
        ]);
    }
    /**===================================METODOS=================================== */
    public function create(Request $request)
    {
        try {
            $content = (object) $request->content;
            if ($request->validateContent([
                'title' => ['required',],
                'money' => ['required', 'max:8', function (string $attribute, mixed $value, Closure $fail) {
                    if ($value < 100) {
                        $fail("O valor do campo 'valor mensal' deve ser maior ou igual a 100.");
                    }
                }],
            ], [], [
                'money' => 'valor mensal'
            ])) {
                return;
            }
            PaymentPlan::creat([
                'title' => $content->title,
                'price' => $content->money,
            ]);
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
}
