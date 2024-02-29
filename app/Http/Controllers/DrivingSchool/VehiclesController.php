<?php

namespace App\Http\Controllers\DrivingSchool;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Facade\NavigateFactory;
use App\Http\Controllers\Controller;

class VehiclesController extends Controller
{
    /**==========================================VIEWS=================================== */
    public function viewCreate()
    {
        $breadcrumb =  NavigateFactory::breadcrumb()
            ->setLink('Auto Escola', route: route('user.driving_school.dashboard'))
            ->setLink('Veículos')
            ->setLink('Lista')
            ->setLink('Novo');
        return Inertia::render('DrivingSchool/Vehicles/Create', [
            'breadcrumb' => $breadcrumb->generate(),
        ]);
    }
    /**===================================METODOS ROUTES=================================== */
    public function create(Request $request)
    {
        ds($request->all(), strtoupper($request->plate));
    }
    /**===================================METODOS ROUTES AXIOS=================================== */
    /**===================================METODOS VARIADOS=================================== */
}
