<?php

use App\Http\Controllers\Admin\PaymentPlanController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
});


Route::group(['prefix' => 'admin/', 'middleware' => 'auth:admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::group(['prefix' => 'payment_plan/'], function () {
        Route::get('/create', [PaymentPlanController::class, 'createView'])->name('payment_plan.createView');
        Route::get('/list', [PaymentPlanController::class, 'index'])->name('payment_plan.index');
        Route::post('/create', [PaymentPlanController::class, 'create'])->name('payment_plan.create');
    });
});
