<?php
namespace App\Http\Controllers\DrivingSchool;

use App\Enum\Database\TypeClient;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
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
            'students' => Client::where('company_id', Auth::user()->company_id)->where('type_client', TypeClient::DRIVING_SCHOOL_STUDENT->value)->count(),
            'teachers' => Client::where('company_id', Auth::user()->company_id)->where('type_client', TypeClient::DRIVING_SCHOOL_TEACHER->value)->count(),
        ];
        return Inertia::render('DrivingSchool/Dashboard', [
            'counts' => $counts,
        ]);
    }
}
