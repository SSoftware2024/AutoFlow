<?php

namespace App\Http\Controllers\DrivingSchool;

use App\Actions\Fortify\PasswordValidationRules;
use Inertia\Inertia;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Facade\MessagesFactory;
use App\Facade\NavigateFactory;
use Illuminate\Validation\Rule;
use App\Enum\Database\TypeClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use App\Enum\Database\DrivingWallet;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\DrivingSchool\Teacher;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    use PasswordValidationRules;
    /**==========================================VIEWS=================================== */
    public function createView(Request $request)
    {
        $breadcrumb = NavigateFactory::breadcrumb()
            ->setLink('Auto Escola', route: route('user.driving_school.dashboard'))
            ->setLink('Professores')
            ->setLink('Lista')
            ->setLink('Novo');
        return Inertia::render('DrivingSchool/Teacher/Create', [
            'breadcrumb' =>  $breadcrumb->generate(),
            'driving_wallet_options' => DrivingWallet::getArrayObjectSelect()
        ]);
    }
    /**===================================METODOS ROUTES=================================== */
    public function create(Request $request)
    {
        //transformando categorias de carteira de habilitação em array simples
        $collect = collect($request->driving_wallet);
        $driving_wallet = $collect->pluck('code')->toArray();
        //valdiação
        Validator::make([...$request->except('driving_wallet'), 'driving_wallet' => $driving_wallet], [
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email', 'unique:clients'],
            'password' => $this->passwordRules(),
            'cpf' => ['required', 'cpf'],
            'birth_date' => ['required', 'date_age:18'],
            'driving_wallet' => ['required'],
            'driving_wallet.*' => [Rule::enum(DrivingWallet::class)],
            'wage' => ['required','numeric'],
            'day_payment' => ['required'],
        ], [], [
            'driving_wallet' => 'carteira de habilitação',
            'wage' => 'slário mensal'
        ])->validate();

        $new_data = [
            'driving_wallet' => $driving_wallet
        ];
        try {
            DB::transaction(function () use ($request, $new_data) {
                $data = $request->except('password_confirmation', 'driving_wallet', 'wage','day_payment');
                $user = Auth::user();
                $client = Client::create([
                    ...$data,
                    'password' => Hash::make($data['password']),
                    'email_verified_at' => now(),
                    'type_client' => TypeClient::DRIVING_SCHOOL_TEACHER->value,
                    'company_id' => $user->company_id,
                    'user_id' => $user->id,
                ]);
                Teacher::create([
                    'client_id' => $client->id,
                    'driving_wallet' => $new_data['driving_wallet'],
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
