<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/pengguna', function () {
    return view('pengguna.dashboard');
});


// Hanya gunakan satu redirect
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');

// Satu callback untuk keduanya
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


Auth::routes(); 
