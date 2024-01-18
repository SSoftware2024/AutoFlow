<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Facade\NavigateFactory;


class DashboardController extends Controller
{
    public function index(Request $request)
    {

        switch ($request->guardName()) {
            case 'web':
                return $this->dashboard($request);
                break;
            case 'admin':
                return redirect()->route('admin.dashboard');
                break;

            default:
                # code...
                break;
        }

        return Inertia::render('Dashboard');
    }

    public function dashboard(Request $request)
    {
        return Inertia::render('Dashboard');
    }
}
