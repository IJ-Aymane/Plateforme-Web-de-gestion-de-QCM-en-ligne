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
    Route::get('/dashboard/Enseignant', [DashboardController::class, 'EnseignantDashboard'])
        ->name('dashboard.Enseignant');

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
    Route::get('/qcms', [QcmController::class, 'index'])->name('qcm.index');
    Route::get('/qcm/available', [QcmController::class, 'available'])->name('qcm.available');
    Route::get('/qcm/{qcm}/take', [QcmController::class, 'take'])->name('qcm.take');
    Route::post('/qcm/{qcm}/submit', [QcmController::class, 'submit'])->name('qcm.submit');
    Route::get('/qcm/create', [QcmController::class, 'create'])->name('qcm.create');
    Route::get('/qcm/{id}', [QcmController::class, 'show'])->name('qcm.show');
    Route::get('/qcm/{id}/edit', [QcmController::class, 'edit'])->name('qcm.edit');   
    Route::delete('/qcm/{id}', [QcmController::class, 'destroy'])->name('qcm.destroy');


    Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');  
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{id}', [QuestionController::class, 'show'])->name('questions.show');
    Route::get('/questions/{id}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');

    
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



    // routes/web.php
    Route::get('/questions/{id}', [App\Http\Controllers\QuestionsController::class, 'show'])
    ->name('questions.show');


    Route::get('/my-results', [QcmController::class, 'myResults'])->name('student.results')->middleware('auth');


    Route::get('/users', [UserController::class, 'index'])->name('users.index');
   Route::get('/resultats', [QcmController::class, 'index'])->name('resultats.index');
   Route::get('/settings', [QcmController::class, 'index'])->name('settings.index');

    
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

  
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

 
    Route::get('/admin/qcms', [AdminController::class, 'qcms'])->name('admin.qcms');
    Route::delete('/admin/qcms/{id}', [AdminController::class, 'destroyQcm'])->name('admin.qcms.destroy');


    Route::get('/admin/results', [AdminController::class, 'results'])->name('admin.results');


});

