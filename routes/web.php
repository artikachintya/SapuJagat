<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\OtpController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;

// Public routes
Route::get('/', function () {
    return view('landing');
});
Route::get('/pengguna', function () {
    return view('pengguna.dashboard');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
});

// Google Auth
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Laravel user auth
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin dashboard
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Satu callback untuk keduanya
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

//Buat Route otpnya
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');

Auth::routes();

// User Tukar Sampah
Route::get('/user/tukarsampah1', function(){
    return view('TukarSampah1');
});
