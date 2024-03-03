<?php

namespace App\Http\Controllers\DrivingSchool;

use App\Actions\Fortify\PasswordValidationRules;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Facade\NavigateFactory;
use App\Http\Controllers\Controller;

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
        $request->validate([
            'name' => ['required','min:5'],
            'email' => ['required', 'email', 'unique:clients'],
            'password' => $this->passwordRules(),
            'cpf' => ['required','cpf'],
            'rg' => ['required','min:8'],
        ]);
    }
}
