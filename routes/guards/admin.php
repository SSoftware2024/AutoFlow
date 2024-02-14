<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Financial\PaymentPlanController;

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
        Route::get('/create', [CompanyController::class, 'createView'])->name('adm.company.createView');
        Route::get('/list', [CompanyController::class, 'index'])->name('adm.company.index');
        Route::get('/edit/{company}', [CompanyController::class, 'editView'])->name('adm.company.editView');
        Route::post('/create', [CompanyController::class, 'create'])->name('adm.company.create');
        Route::post('/update', [CompanyController::class, 'update'])->name('adm.company.update');
        Route::patch('/deleteImage', [CompanyController::class, 'deleteImage'])->name('adm.company.deleteImage');
        Route::delete('/delete/{id}', [CompanyController::class, 'delete'])->name('adm.company.delete');
    });
    Route::group(['prefix' => 'user/'], function () {
        Route::get('/create', [UserController::class, 'createView'])->name('adm.user.createView');
        Route::get('/list', [UserController::class, 'index'])->name('adm.user.index');
        Route::post('/create', [UserController::class, 'create'])->name('adm.user.create');

    });
});
