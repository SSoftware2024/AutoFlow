<?php

namespace App\Http\Controllers\DrivingSchool;

use App\Models\User;
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
use App\Models\DrivingSchool\Student;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;

class StudentController extends Controller
{
    use PasswordValidationRules;
    /**==========================================VIEWS=================================== */
    public function index(Request $request)
    {
        $breadcrumb = NavigateFactory::breadcrumb()
            ->setLink('Auto Escola', route: route('user.driving_school.dashboard'))
            ->setLink('Alunos')
            ->setLink('Lista');
        $students = Client::where('company_id', Auth::user()->company_id)->select(
            'id',
            'name',
            'profile_photo_path'
        )->paginate(10);
        return Inertia::render('DrivingSchool/Students/List', [
            'breadcrumb' =>  $breadcrumb->generate(),
            'students' => $students,
            'images' => [
                'user_profile' => asset('img/profile-default.png')
            ]
        ]);
    }
    public function createView(Request $request)
    {
        $breadcrumb = NavigateFactory::breadcrumb()
            ->setLink('Auto Escola', route: route('user.driving_school.dashboard'))
            ->setLink('Alunos')
            ->setLink('Lista', route: route('user.driving_school.students.index'))
            ->setLink('Novo');
        return Inertia::render('DrivingSchool/Students/Create', [
            'breadcrumb' =>  $breadcrumb->generate(),
            'driving_wallet_options' => DrivingWallet::getArrayObjectSelect()
        ]);
    }
    /**===================================METODOS ROUTES=================================== */
    public function create(Request $request)
    {
        $responsible_id = $request->responsible_id == 0 ? null : $request->responsible_id;
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
            'responsible_id' => ['nullable', 'bigger_then'],
            'driving_wallet' => ['required'],
            'driving_wallet.*' => [Rule::enum(DrivingWallet::class)],
            'course_price' => ['required', 'bigger_then'],
        ], [], [
            'driving_wallet' => 'carteira de habilitação',
            'course_price' => 'valor'
        ])->validate();

        $new_data = [
            'responsible_id' => $responsible_id,
            'driving_wallet' => $driving_wallet
        ];
        try {
            DB::transaction(function () use ($request, $new_data) {
                $data = $request->except('password_confirmation', 'driving_wallet', 'course_price');
                $user = Auth::user();
                $client = Client::create([
                    ...$data,
                    'responsible_id' => $new_data['responsible_id'],
                    'password' => Hash::make($data['password']),
                    'email_verified_at' => now(),
                    'type_client' => TypeClient::DRIVING_SCHOOL_STUDENT->value,
                    'company_id' => $user->company_id,
                    'user_id' => $user->id,
                ]);
                Student::create([
                    'client_id' => $client->id,
                    'driving_wallet' => $new_data['driving_wallet'],
                    'course_price' => $request->course_price,
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
    /**===================================METODOS ROUTES AXIOS=================================== */
    public function getResponsibles(Request $request)
    {
        $responsibles = null;
        if (!empty($request->responsible)) {
            $responsibles = User::where('id', $request->responsible)->orWhere('name', 'like', "%" . $request->responsible . "%")->select('id', 'name')->cursor();
            $selectOptions = $responsibles->map(function ($value) {
                return  [
                    'name' => $value->id . ' - ' . $value->name,
                    'code' => $value->id
                ];
            });
        } else return null;
        return json_encode($selectOptions);
    }
    /**===================================METODOS VARIADOS=================================== */
}
