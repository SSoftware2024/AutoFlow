<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\PaymentPlan;
use Illuminate\Http\Request;
use Closure;
use App\Facade\NavigateFactory;
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
        $content = (object) $request->content;;
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
    }
}
