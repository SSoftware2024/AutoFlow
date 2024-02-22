<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Facade\NavigateFactory;
use App\Http\Controllers\Controller;
use App\Models\Administrator;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
        ->setLink('Administrador')
        ->setLink('Lista');
        $administrators = Administrator::paginate(10);
        return Inertia::render('Admin/List', [
            'breadcrumb' => $breadcrumb->generate(),
            'administrators' => $administrators
        ]);
    }
}
