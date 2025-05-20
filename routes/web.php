<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login1', function () {
    return view('auth.login1');
});

Route::get('/register1', function () {
    return view('auth.register1'); // nama file: register1.blade.php
})->name('register1');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
