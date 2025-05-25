<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\OtpController;



use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;

// Web Routes

// Public homepage
Route::get('/', function () {
    return view('welcome');
});

// Landing page
Route::get('/landing-page', function () {
    return view('landing-page.index');
});

// Pengguna dashboard (you might want to protect this with middleware later)
Route::get('/pengguna', function () {
    return view('pengguna.dashboard');
});

// Google Auth Routes
// Hanya gunakan satu redirect
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');

// Laravel Default Auth Routes

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin Auth Routes

Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'login'])->name('admin.login.submit');
Route::post('admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// Admin dashboard (requires admin guard)

Route::middleware('auth:admin')->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});
// Satu callback untuk keduanya
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

//Buat Route otpnya
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');

Auth::routes();
