<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QcmController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResultatController;

// =============================
// Authentication routes
// =============================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// =============================
// Public routes
// =============================
Route::get('/', [DashboardController::class, 'welcome'])->name('welcome');

// =============================
// Protected routes (auth required)
// =============================
Route::middleware(['auth'])->group(function () {

    // Dashboards
    Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])
        ->name('dashboard.admin')
        ->middleware('role:enseignant');

    Route::get('/dashboard/student', [DashboardController::class, 'studentDashboard'])
        ->name('dashboard.student')
        ->middleware('role:etudiant');

    // =========================
    // Teacher routes
    // =========================
    Route::middleware('role:enseignant')->group(function () {
        Route::resource('qcm', QcmController::class);
        Route::resource('questions', QuestionController::class);
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/resultats', [ResultatController::class, 'index'])->name('resultats.index');
        Route::get('/settings', [DashboardController::class, 'settings'])->name('settings.index');
    });

    // =========================
    // Student routes
    // =========================
    Route::middleware('role:etudiant')->group(function () {
        Route::get('/qcm/available', [QcmController::class, 'available'])->name('qcm.available');
        Route::get('/student/results', [ResultatController::class, 'studentResults'])->name('student.results');
        Route::get('/qcm/{qcm}/take', [QcmController::class, 'take'])->name('qcm.take');
        Route::post('/qcm/{qcm}/submit', [QcmController::class, 'submit'])->name('qcm.submit');
    });
});
