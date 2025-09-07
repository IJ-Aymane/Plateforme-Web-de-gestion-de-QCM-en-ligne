<?php

use Illuminate\Support\Facades\Route;

// Home page route (showing the welcome/dashboard page)
Route::get('/', function () {
    return view('welcome');
});

// Login page route
Route::get('/login', function () {
    return view('login');
});


// dashboardAdmin page route
Route::get('/dashboardAdmin', function () {
    return view('dashboardAdmin');
});
// Additional routes you might need:
// Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
// Route::get('/dashboard', function () {
//     return view('welcome');
// })->name