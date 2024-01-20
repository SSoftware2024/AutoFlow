<?php

namespace App\Http\Controllers\Admin;

use App\Facade\NavigateFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        $request->validate([
            'title' => ['required']
        ]);
        dd($request->money,$request->title);
    }
}
