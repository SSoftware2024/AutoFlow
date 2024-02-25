<?php

namespace App\Http\Controllers\Financial;

use App\Facade\MessagesFactory;
use Closure;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Facade\NavigateFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use  App\Models\Financial\PaymentPlan;;

class PaymentPlanController extends Controller
{

    public function __construct()
    {
    }
    public function index(Request $request)
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Plano de pagamento')
            ->setLink('Lista');
        $paymentPlan = PaymentPlan::read(changeMoney:true);
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
        $request->validate([
            'title' => ['required'],
            'money' => ['required', 'max:8', function (string $attribute, mixed $value, Closure $fail) {
                if ($value < 100) {
                    $fail("O valor do campo 'valor mensal' deve ser maior ou igual a 100.");
                }
            }],
        ], [], [
            'money' => 'valor mensal'
        ]);
        $arrayValid = $this->validPermissionsArray($request->permissions);
        if(!$arrayValid){
            return redirect()->back()->withErrors(['catch' => 'Selecione pelo menos uma permissão para o plano de pagamento'] );
        }
        try {
            DB::transaction(function () use ($request) {
                PaymentPlan::create([
                    'title' => $request->title,
                    'price' => $request->money,
                    'permissions' => json_encode($request->permissions)
                ]);
            });
            MessagesFactory::toast()->success('Operação realizada com sucesso')->generate();
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'money' => ['required', 'max:8', function (string $attribute, mixed $value, Closure $fail) {
                if ($value < 100) {
                    $fail("O valor do campo 'valor mensal' deve ser maior ou igual a 100.");
                }
            }],
        ], [], [
            'money' => 'valor mensal'
        ]);
        $arrayValid = $this->validPermissionsArray($request->permissions);
        if(!$arrayValid){
            return redirect()->back()->withErrors(['catch' => 'Selecione pelo menos uma permissão para o plano de pagamento'] );
        }
        try {
            DB::transaction(function () use ($request) {
                PaymentPlan::where('id', $request->id)->update([
                    'title' => $request->title,
                    'price' => $request->money,
                    'permissions' => json_encode($request->permissions)
                ]);
            });
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }
    }
    public function delete(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                PaymentPlan::where('id', $request->id)->delete();
            });
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('catch', $e->getMessage());
            return redirect()->back()->withErrors($errors);
        }

    }
    /**===============================================PRIVADOS==============================================================*/

    private function validPermissionsArray(array $array):bool
    {
        $arrayValid = false;
        foreach ($array as $key => $options) {
            foreach ($options as $key2 => $value) {
                if($value['value']){
                    $arrayValid = true;
                    break;
                }
            }
            if($arrayValid){
                break;
            }
        }
        return $arrayValid;
    }
}
