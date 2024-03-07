<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DrivingSchool\VehiclesController;
use App\Http\Controllers\DrivingSchool\DrivingSchoolController;
use App\Http\Controllers\DrivingSchool\StudentController;
use App\Http\Controllers\DrivingSchool\TeacherController;

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

Route::group(['prefix' => 'driving-school/', 'middleware' => ['auth',config('jetstream.auth_session')]], function () {
    Route::get('/dashboard', [DrivingSchoolController::class, 'index'])->name('user.driving_school.dashboard');

    Route::group(['prefix' => 'vehicles/'], function () {
        Route::get('/create', [VehiclesController::class, 'createView'])->name('user.driving_school.vehicles.createView');
        Route::get('/list', [VehiclesController::class, 'index'])->name('user.driving_school.vehicles.index');
        Route::get('/edit/{vehicle}', [VehiclesController::class, 'editView'])->name('user.driving_school.vehicles.editView');
        Route::post('/create', [VehiclesController::class, 'create'])->name('user.driving_school.vehicles.create');
        Route::put('/update', [VehiclesController::class, 'update'])->name('user.driving_school.vehicles.update');
        Route::delete('/delete/{id}', [VehiclesController::class, 'delete'])->name('user.driving_school.vehicles.delete');
    });
    Route::group(['prefix' => 'students/'], function () {
        Route::get('/list', [StudentController::class, 'index'])->name('user.driving_school.students.index');
        Route::get('/create', [StudentController::class, 'createView'])->name('user.driving_school.students.createView');
        Route::get('/edit/{student}', [StudentController::class, 'editView'])->name('user.driving_school.students.editView');
        Route::get('/ax-getResponsibles', [StudentController::class, 'getResponsibles'])->name('user.driving_school.students.ax.getResponsibles');
        Route::post('/create', [StudentController::class, 'create'])->name('user.driving_school.students.create');
        Route::put('/update', [StudentController::class, 'update'])->name('user.driving_school.students.update');
        Route::delete('/delete/{id}', [StudentController::class, 'delete'])->name('user.driving_school.students.delete');
    });
    Route::group(['prefix' => 'teachers/'], function () {
        Route::get('/list', [TeacherController::class, 'index'])->name('user.driving_school.teacher.index');
        Route::get('/create', [TeacherController::class, 'createView'])->name('user.driving_school.teacher.createView');
        Route::get('/edit/{teacher}', [TeacherController::class, 'editView'])->name('user.driving_school.teacher.editView');
        Route::post('/create', [TeacherController::class, 'create'])->name('user.driving_school.teacher.create');
        Route::put('/update', [TeacherController::class, 'update'])->name('user.driving_school.teacher.update');
        Route::delete('/delete/{id}', [TeacherController::class, 'delete'])->name('user.driving_school.teacher.delete');
    });
});
require 'guards/admin.php';
