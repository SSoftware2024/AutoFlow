<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Financial\PaymentPlanController;

Route::group(['prefix' => 'admin/', 'middleware' => 'auth:admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::group(['middleware' => 'admin_first'], function () {
        Route::get('/list', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/create', [AdminController::class, 'createView'])->name('admin.createView');
        Route::get('/edit/{administrator}', [AdminController::class, 'editView'])->name('admin.editView');
        Route::put('/edit', [AdminController::class, 'update'])->name('admin.update');
        Route::post('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::delete('/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete');
    });

    Route::group(['prefix' => 'payment_plan/'], function () {
        Route::get('/create', [PaymentPlanController::class, 'createView'])->name('payment_plan.createView');
        Route::get('/edit/{paymentPlan}', [PaymentPlanController::class, 'editView'])->name('payment_plan.editView');
        Route::get('/list', [PaymentPlanController::class, 'index'])->name('payment_plan.index');
        Route::post('/create', [PaymentPlanController::class, 'create'])->name('payment_plan.create');
        Route::put('/update', [PaymentPlanController::class, 'update'])->name('payment_plan.update');
        Route::delete('/delete/{id}', [PaymentPlanController::class, 'delete'])->name('payment_plan.delete');
    });
    Route::group(['prefix' => 'company/'], function () {
        Route::get('/create', [CompanyController::class, 'createView'])->name('adm.company.createView');
        Route::get('/list', [CompanyController::class, 'index'])->name('adm.company.index');
        Route::get('/list-responsible/{company?}', [CompanyController::class, 'listResponsiblesView'])->name('adm.company.listResponsibleView');
        Route::get('/edit/{company}', [CompanyController::class, 'editView'])->name('adm.company.editView');
        Route::post('/create', [CompanyController::class, 'create'])->name('adm.company.create');
        Route::put('/update', [CompanyController::class, 'update'])->name('adm.company.update');
        Route::patch('/deleteImage', [CompanyController::class, 'deleteImage'])->name('adm.company.deleteImage');
        Route::delete('/delete/{id}', [CompanyController::class, 'delete'])->name('adm.company.delete');
        Route::post('/new-responsible', [CompanyController::class, 'newResponsible'])->name('adm.company.newResponsible');
    });
    Route::group(['prefix' => 'user/'], function () {
        Route::get('/create', [UserController::class, 'createView'])->name('adm.user.createView');
        Route::match(['get', 'post'], '/list', [UserController::class, 'index'])->name('adm.user.index');
        Route::get('/edit/{user}', [UserController::class, 'editView'])->name('adm.user.editView');
        Route::post('/create', [UserController::class, 'create'])->name('adm.user.create');
        Route::patch('/update', [UserController::class, 'update'])->name('adm.user.update');
        Route::patch('/update-password', [UserController::class, 'updatePassword'])->name('adm.user.updatePassword');
        Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('adm.user.delete');
        Route::delete('/delete/disable-company/{user}', [UserController::class, 'deleteAndDisableCompany'])->name('adm.user.deleteAndDisableCompany');
    });
});
