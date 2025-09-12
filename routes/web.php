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

// Password reset routes (if needed)
Route::get('/password/reset', [AuthController::class, 'showResetForm'])->name('password.request');
Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update');

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
    // Teacher routes (Enseignant only)
    // =========================
    Route::middleware('role:enseignant')->group(function () {
        
        // QCM Management
        Route::resource('qcm', QcmController::class);
        
        // Questions Management
        Route::resource('questions', QuestionController::class);
        
        // User Management - Complete CRUD operations
        Route::resource('users', UserController::class)->names([
            'index' => 'users.index',
            'create' => 'users.create',
            'store' => 'users.store',
            'show' => 'users.show',
            'edit' => 'users.edit',
            'update' => 'users.update',
            'destroy' => 'users.destroy',
        ]);
        
        // Results Management
        Route::get('/resultats', [ResultatController::class, 'index'])->name('resultats.index');
        Route::get('/resultats/{resultat}', [ResultatController::class, 'show'])->name('resultats.show');
        Route::delete('/resultats/{resultat}', [ResultatController::class, 'destroy'])->name('resultats.destroy');
        
        // Settings
        Route::get('/settings', [DashboardController::class, 'settings'])->name('settings.index');
        Route::put('/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');
    });

    // =========================
    // Student routes (Étudiant only)
    // =========================
    Route::middleware('role:etudiant')->group(function () {
        
        // Available qcm for students
        Route::get('/qcm/available', [QcmController::class, 'available'])->name('qcm.available');
        
        // Take QCM
        Route::get('/qcm/{qcm}/take', [QcmController::class, 'take'])->name('qcm.take');
        Route::post('/qcm/{qcm}/submit', [QcmController::class, 'submit'])->name('qcm.submit');
        
        // Student Results
        Route::get('/student/results', [ResultatController::class, 'studentResults'])->name('student.results');
        Route::get('/student/results/{resultat}', [ResultatController::class, 'studentResultShow'])->name('student.results.show');
    });

    // =========================
    // Shared routes (Both roles)
    // =========================
    
    // Profile management
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.show');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');
    
    // Dashboard redirect based on role
    Route::get('/dashboard', [DashboardController::class, 'redirectToDashboard'])->name('dashboard');
});