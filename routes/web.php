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

    // Main Student Dashboard - This renders dashboardStudent.blade.php
    Route::get('/dashboard/student', [DashboardController::class, 'studentDashboard'])
        ->name('dashboard.student');

    // Admin Dashboard  
    Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])
        ->name('dashboard.admin');

    // Dashboard redirect
    Route::get('/dashboard', [DashboardController::class, 'redirectToDashboard'])
        ->name('dashboard');

    // =========================
    // Admin/Teacher routes
    // =========================
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // QCM Management
        Route::resource('qcm', QcmController::class);
        
        // Questions Management
        Route::resource('questions', QuestionController::class);
        
        // User Management
        Route::resource('users', UserController::class);
        
        // Results Management
        Route::get('/resultats', [ResultatController::class, 'index'])->name('resultats.index');
        Route::get('/resultats/{resultat}', [ResultatController::class, 'show'])->name('resultats.show');
        Route::delete('/resultats/{resultat}', [ResultatController::class, 'destroy'])->name('resultats.destroy');
        
        // Settings
        Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    });

    // =========================
    // QCM routes (for students)
    // =========================
    // Available QCM for students
    Route::get('/qcm/available', [QcmController::class, 'available'])->name('qcm.available');
    Route::get('/qcm/{qcm}/take', [QcmController::class, 'take'])->name('qcm.take');
    Route::post('/qcm/{qcm}/submit', [QcmController::class, 'submit'])->name('qcm.submit');
    
    // =========================
    // Student routes
    // =========================
    Route::prefix('student')->name('student.')->group(function () {
        
        // Student Results
        Route::get('/results', [ResultatController::class, 'studentResults'])->name('results');
        Route::get('/results/{resultat}', [ResultatController::class, 'studentResultShow'])->name('results.show');
        
        // Student History
        Route::get('/history', [ResultatController::class, 'studentResults'])->name('history');
    });

    // =========================
    // Profile routes
    // =========================
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.show');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');
});