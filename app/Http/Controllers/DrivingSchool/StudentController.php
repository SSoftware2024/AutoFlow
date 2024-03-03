<?php

namespace App\Http\Controllers\DrivingSchool;

use Inertia\Inertia;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Facade\MessagesFactory;
use App\Facade\NavigateFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\PasswordValidationRules;
use App\Enum\Database\TypeClient;

class StudentController extends Controller
{
    use PasswordValidationRules;
    /**==========================================VIEWS=================================== */
    public function createView()
    {
        $breadcrumb = NavigateFactory::breadcrumb()
            ->setLink('Auto Escola', route: route('user.driving_school.dashboard'))
            ->setLink('Alunos')
            ->setLink('Lista')
            ->setLink('Novo');
        return Inertia::render('DrivingSchool/Students/Create', [
            'breadcrumb' =>  $breadcrumb->generate(),
        ]);
    }
    /**===================================METODOS ROUTES=================================== */
    public function create(Request $request)
    {
        $responsible_id = $request->responsible_id == 0 ? null : $request->responsible_id;
        $request->validate([
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email', 'unique:clients'],
            'password' => $this->passwordRules(),
            'cpf' => ['required', 'cpf'],
            'rg' => ['required', 'min:8'],
            'birth_date' => ['required', 'date_age:18'],
            'responsible_id' => ['nullable', 'bigger_then'],
        ]);
        try {
            DB::transaction(function () use ($request, $responsible_id) {
                $data = $request->except('password_confirmation');
                $user = Auth::user();
                Client::create([
                    ...$data,
                    'responsible_id' => $responsible_id,
                    'password' => Hash::make($data['password']),
                    'email_verified_at' => now(),
                    'type_client' => TypeClient::DRIVING_SCHOOL_STUDENT->value,
                    'company_id' => $user->company_id,
                    'user_id' => $user->id,
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
