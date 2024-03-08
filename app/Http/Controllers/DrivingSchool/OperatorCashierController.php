<?php

namespace App\Http\Controllers\DrivingSchool;

use App\Actions\Fortify\PasswordValidationRules;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Facade\MessagesFactory;
use App\Facade\NavigateFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use App\Enum\Database\DrivingWallet;
use App\Http\Controllers\Controller;
use App\Models\OperatorCashier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OperatorCashierController extends Controller
{
    use PasswordValidationRules;
    /**==========================================VIEWS=================================== */
    public function createView(Request $request)
    {
        $breadcrumb = NavigateFactory::breadcrumb()
            ->setLink('Auto Escola', route: route('user.driving_school.dashboard'))
            ->setLink('Balconista')
            ->setLink('Lista')
            ->setLink('Novo');
        return Inertia::render('DrivingSchool/OperatorCashier/Create', [
            'breadcrumb' =>  $breadcrumb->generate()
        ]);
    }
    /**===================================METODOS ROUTES=================================== */
    public function create(Request $request)
    {
        //transformando categorias de carteira de habilitação em array simples
        $collect = collect($request->driving_wallet);
        //valdiação
        $request->validate([
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email', 'unique:operator_cashiers'],
            'password' => $this->passwordRules(),
            'wage' => ['required', 'numeric'],
            'day_payment' => ['required'],
        ], [], [
            'wage' => 'salário mensal'
        ]);
        try {
            DB::transaction(function () use ($request) {
                $data = $request->except('password_confirmation');
                $user = Auth::user();
                OperatorCashier::create([
                    ...$data,
                    'company_id' => $user->company_id,
                    'user_id' => $user->id,
                    'password' => Hash::make($data['password']),
                    'email_verified_at' => now(),
                    'wage' => $request->wage,
                    'day_payment' => $request->day_payment,
                ]);

                MessagesFactory::toast()->success('Operação concluída com sucesso')
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
}
