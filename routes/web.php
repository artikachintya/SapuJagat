<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\OtpController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TukarSampahController;

// Public routes
Route::get('/', function () {
    return view('landing');
});
Route::get('/pengguna/dashboard', function () {
    return view('pengguna.dashboard');
});

// Google OAuth
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
Route::get('/pengguna/tukar-sampah', [TukarSampahController::class, 'index'])->name('TukarSampah1');
Route::post('/pengguna/tukar-sampah/submit', [TukarSampahController::class, 'submit'])->name('tukar-sampah.submit');
