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
    public function index(Request $request)
    {
        $breadcrumb = NavigateFactory::breadcrumb()
            ->setLink('Auto Escola', route: route('user.driving_school.dashboard'))
            ->setLink('Professores')
            ->setLink('Lista');
        $client = Client::query()->where('company_id', Auth::user()->company_id)
            ->where('type_client', TypeClient::DRIVING_SCHOOL_TEACHER->value)
            ->select('id', 'name', 'profile_photo_path');
        if (isset($request->filter) && !empty($request->filter)) {
            $filter = (object)$request->filter;
            !is_numeric($filter->value) ? $client->where('name', 'like', "%" . $filter->value . "%") : $client->where('id', $filter->value);
        }
        $teachers = $client->paginate(10);
        return Inertia::render('DrivingSchool/Teacher/List', [
            'breadcrumb' =>  $breadcrumb->generate(),
            'teachers' => $teachers,
            'images' => [
                'user_profile' => asset('img/profile-default.png')
            ]
        ]);
    }
    public function createView(Request $request)
    {
        $breadcrumb = NavigateFactory::breadcrumb()
            ->setLink('Auto Escola', route: route('user.driving_school.dashboard'))
            ->setLink('Professores')
            ->setLink('Lista', route: route('user.driving_school.teacher.index'))
            ->setLink('Novo');
        return Inertia::render('DrivingSchool/Teacher/Create', [
            'breadcrumb' =>  $breadcrumb->generate(),
            'driving_wallet_options' => DrivingWallet::getArrayObjectSelect()
        ]);
    }
    public function editView(Client $teacher)
    {
        $breadcrumb = NavigateFactory::breadcrumb()
            ->setLink('Auto Escola', route: route('user.driving_school.dashboard'))
            ->setLink('Professores')
            ->setLink('Lista', route: route('user.driving_school.teacher.index'))
            ->setLink('Editar');

        $drinving_teacher = $teacher->teacher;
        $drinving_teacher->driving_wallet = collect($drinving_teacher->driving_wallet)->map(function ($value) {
            return [
                'name' => $value,
                'code' => $value
            ];
        });
        return Inertia::render('DrivingSchool/Teacher/Edit', [
            'breadcrumb' =>  $breadcrumb->generate(),
            'driving_wallet_options' => DrivingWallet::getArrayObjectSelect(),
            'client' => [
                'value' => $teacher,
                'teacher' => $drinving_teacher
            ]
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
            'wage' => ['required', 'numeric'],
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
                $data = $request->except('password_confirmation', 'driving_wallet', 'wage', 'day_payment');
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
    public function update(Request $request)
    {
        //transformando categorias de carteira de habilitação em array simples
        $collect = collect($request->driving_wallet);
        $driving_wallet = $collect->pluck('code')->toArray();
        //valdiação
        Validator::make([...$request->except('driving_wallet'), 'driving_wallet' => $driving_wallet], [
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email', Rule::unique('clients')->ignore($request->id)],
            'password' => $this->passwordRulesExists(),
            'cpf' => ['required', 'cpf'],
            'birth_date' => ['required', 'date_age:18'],
            'driving_wallet' => ['required'],
            'driving_wallet.*' => [Rule::enum(DrivingWallet::class)],
            'wage' => ['required', 'numeric'],
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
                $toast = MessagesFactory::toast();
                $data = $request->except('password_confirmation', 'driving_wallet', 'wage', 'day_payment');
                if (!empty($request->password)) {
                    $data['password'] = Hash::make($data['password']);
                    $toast->info('Senha atualizada com sucesso');
                } else {
                    unset($data['password']);
                }
                $user = Auth::user();
                $client = Client::where('id', $request->id)->update([
                    ...$data,
                    'email_verified_at' => now(),
                    'type_client' => TypeClient::DRIVING_SCHOOL_TEACHER->value,
                    'company_id' => $user->company_id,
                    'user_id' => $user->id,
                ]);
                Teacher::where('client_id', $request->id)->update([
                    'driving_wallet' => $new_data['driving_wallet'],
                    'wage' => $request->wage,
                    'day_payment' => $request->day_payment,
                ]);
                $toast->success('Operação concluída com sucesso')
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

    public function delete(int $id)
    {
        try {
            DB::transaction(function () use ($id) {
                Teacher::where('client_id', $id)->delete();
                Client::where('id', $id)->delete();
                MessagesFactory::toast()->info('Operação concluída com sucesso')->generate();
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
