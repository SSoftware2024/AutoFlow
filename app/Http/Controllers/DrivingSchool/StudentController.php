<?php

namespace App\Http\Controllers\DrivingSchool;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Facade\NavigateFactory;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
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
}
