<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

// Show login and registration form
Route::get('/login', function () {
    return view('auth.login-register');
})->name('login');

// Submit login form
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.submit');

// Submit registration form
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Protected dashboard route after login
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');use Illuminate\Support\Facades\Auth;

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');