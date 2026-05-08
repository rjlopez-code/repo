<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResidentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Routes
Route::middleware('auth')->get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

Route::middleware('auth')->get('/official/dashboard', [DashboardController::class, 'officialDashboard'])->name('official.dashboard');

// Resident Routes (require login)
Route::middleware('auth')->group(function () {

    Route::get('/residents', [ResidentController::class, 'index'])->name('residents.index');

    Route::get('/residents/create', [ResidentController::class, 'create'])->name('residents.create');

    Route::post('/residents', [ResidentController::class, 'store'])->name('residents.store');

    Route::get('/residents/{id}/edit', [ResidentController::class, 'edit'])->name('residents.edit');

    Route::put('/residents/{id}', [ResidentController::class, 'update'])->name('residents.update');

    Route::delete('/residents/{id}', [ResidentController::class, 'destroy'])->name('residents.destroy');

    Route::get('/households', [ResidentController::class, 'households'])->name('residents.households');

    // PHOTO UPLOAD ROUTE
    Route::post('/admin/residents/{id}/photo', [ResidentController::class, 'updatePhoto'])
        ->name('admin.residents.photo');
});