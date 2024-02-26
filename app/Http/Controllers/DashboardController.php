<?php
namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        switch (guardName()) { //retorna nome do guard
            case 'web':
                return $this->dashboard($request);
                break;
            case 'admin':
                return redirect()->route('admin.dashboard');
                break;

            default:

                break;
        }

        // return Inertia::render('Dashboard');
    }

    public function dashboard(Request $request)
    {
        return Inertia::render('User/Dashboard');
    }
}
