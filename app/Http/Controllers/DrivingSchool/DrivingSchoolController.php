<?php
namespace App\Http\Controllers\DrivingSchool;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DrivingSchool\Vehicles;


class DrivingSchoolController extends Controller
{

    /**
     * Dashboard de auto-esocla para usuarios, guard web
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {

        $counts = [
            'vehicles' => Vehicles::where('company_id', Auth::user()->company_id)->count(),
        ];
        return Inertia::render('DrivingSchool/Dashboard', [
            'counts' => $counts,
        ]);
    }
}
