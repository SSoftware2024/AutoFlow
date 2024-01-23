<?php

namespace App\Http\Controllers\Admin;

use Closure;
use Inertia\Inertia;
use App\Models\PaymentPlan;
use Illuminate\Http\Request;
use App\Facade\NavigateFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PaymentPlanController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Plano de pagamento')
            ->setLink('Lista');
        $paymentPlan = PaymentPlan::cursor();
        return Inertia::render('Admin/PaymentPlan/List', [
            'breadcrumb' => $breadcrumb->generate(),
            'payment_plan' => $paymentPlan
        ]);
    }
    public function createView(Request $request)
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Plano de pagamento')
            ->setLink('Lista', false, route('payment_plan.index'))
            ->setLink('Novo');
        return Inertia::render('Admin/PaymentPlan/Create', [
            'breadcrumb' => $breadcrumb->generate()
        ]);
    }
    public function editView(Request $request, PaymentPlan $paymentPlan)
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Plano de pagamento')
            ->setLink('Lista', false, route('payment_plan.index'))
            ->setLink('Editar');
        return Inertia::render('Admin/PaymentPlan/Edit', [
            'breadcrumb' => $breadcrumb->generate(),
            'payment_plan' => $paymentPlan
        ]);
    }
    /**===================================METODOS=================================== */
    public function create(Request $request)
    {
        DB::beginTransaction();
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
            PaymentPlan::create([
                'title' => $content->title,
                'price' => $content->money,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
    public function update(Request $request)
    {
        DB::beginTransaction();
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
            PaymentPlan::where('id', $request->id)->update([
                'title' => $content->title,
                'price' => $content->money,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
}
