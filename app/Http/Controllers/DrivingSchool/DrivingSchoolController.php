<?php

namespace App\Http\Controllers\DrivingSchool;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DrivingSchoolController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('DrivingSchool/Dashboard');
    }
}
