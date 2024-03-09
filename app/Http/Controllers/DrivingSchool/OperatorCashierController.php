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
    public function index(Request $request)
    {
        $breadcrumb = NavigateFactory::breadcrumb()
            ->setLink('Auto Escola', route: route('user.driving_school.dashboard'))
            ->setLink('Balconista')
            ->setLink('Lista');
        $operator_cashiers = OperatorCashier::query()->where('company_id', Auth::user()->company_id)
            ->select('id', 'name', 'profile_photo_path');
        if (isset($request->filter) && !empty($request->filter)) {
            $filter = (object)$request->filter;
            !is_numeric($filter->value) ? $operator_cashiers->where('name', 'like', "%" . $filter->value . "%") : $operator_cashiers->where('id', $filter->value);
        }
        return Inertia::render('DrivingSchool/OperatorCashier/List', [
            'breadcrumb' =>  $breadcrumb->generate(),
            'operator_cashiers' => $operator_cashiers->paginate(10),
            'images' => [
                'user_profile' => asset('img/profile-default.png')
            ]
        ]);
    }
    public function createView(Request $request)
    {
        $breadcrumb = NavigateFactory::breadcrumb()
            ->setLink('Auto Escola', route: route('user.driving_school.dashboard'))
            ->setLink('Balconista')
            ->setLink('Lista', route: route('user.driving_school.operator_cashier.index'))
            ->setLink('Novo');
        return Inertia::render('DrivingSchool/OperatorCashier/Create', [
            'breadcrumb' =>  $breadcrumb->generate(),
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
