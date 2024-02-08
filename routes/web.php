<?php

use App\Http\Controllers\Admin\CompanyController;
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
        Route::get('/edit/{paymentPlan}', [PaymentPlanController::class, 'editView'])->name('payment_plan.editView');
        Route::get('/list', [PaymentPlanController::class, 'index'])->name('payment_plan.index');
        Route::post('/create', [PaymentPlanController::class, 'create'])->name('payment_plan.create');
        Route::put('/update', [PaymentPlanController::class, 'update'])->name('payment_plan.update');
        Route::delete('/delete/{id}', [PaymentPlanController::class, 'delete'])->name('payment_plan.delete');
    });
    Route::group(['prefix' => 'company/'], function () {
        Route::get('/create', [CompanyController::class, 'createView'])->name('company.createView');
        Route::get('/list', [CompanyController::class, 'index'])->name('company.index');
        Route::get('/edit/{company}', [CompanyController::class, 'editView'])->name('company.editView');
        Route::post('/create', [CompanyController::class, 'create'])->name('company.create');
        Route::post('/update', [CompanyController::class, 'update'])->name('company.update');
        Route::patch('/deleteImage', [CompanyController::class, 'deleteImage'])->name('company.deleteImage');
        Route::delete('/delete/{id}', [CompanyController::class, 'delete'])->name('company.delete');
    });
});
