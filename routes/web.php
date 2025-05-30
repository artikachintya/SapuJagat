<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\HistoriAdmin;
use App\Http\Controllers\Admin\JenisSampahController;
use App\Http\Controllers\Admin\Persetujuan;
use App\Http\Controllers\Admin\PrintData;
use App\Http\Controllers\Admin\ResponLaporan;

use App\Http\Controllers\Pengguna\Histori;
use App\Http\Controllers\Pengguna\LaporanController;
use App\Http\Controllers\Pengguna\Pelacakan;
use App\Http\Controllers\Pengguna\PenggunaController;
use App\Http\Controllers\Pengguna\TukarSampahController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\OtpController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RingkasanPesananController;
use App\Http\Controllers\ChatController;

// Public routes
Route::get('/', function () {
    return view('landing');
});

Route::get('/pengguna/dashboard', function () {
    return view('pengguna.dashboard');
});
// Route::get('/pengguna', function () {
//     return view('pengguna.dashboard');
// });

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
// Route::middleware('auth')->group(function () {
//     Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
// });

// Satu callback untuk keduanya
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

//Buat Route otpnya
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');

Auth::routes();


// User Tukar Sampah
// user step 1 : tukar sampah
Route::get('/pengguna/tukar-sampah', [TukarSampahController::class, 'index'])->name('TukarSampah1');
Route::post('/pengguna/tukar-sampah/submit', [TukarSampahController::class, 'submit'])->name('tukar-sampah.submit');
// user step 2 : ringkasan pesanan
Route::get('/pengguna/ringkasan-pesanan', [TukarSampahController::class,'ringkasan'])->name('RingkasanPesanan2');
Route::post('/pengguna/ringkasan-pesanan/jemput', [RingkasanPesananController::class,'jemput'])->name('ringkasan.jemput');

// Chat routes
// Route::prefix('chat')->middleware('auth')->group(function () {
//     // Main chat interface
//     Route::get('/', [ChatController::class, 'index'])->name('chat.index');

//     // View specific chat
//     Route::get('/{chatId}', [ChatController::class, 'index'])->name('chat.show');

//     // Send message
//     Route::post('/{chatId}/send', [ChatController::class, 'sendMessage'])->name('chat.send');

//     // Start new chat with user
//     Route::get('/start/{userId}', [ChatController::class, 'startChat'])->name('chat.start');
// });

Route::prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/', [PenggunaController::class, 'index'])->name('dashboard');
    Route::resource('tukar-sampah', TukarSampahController::class);
    Route::resource('histori', Histori::class);
    Route::resource('pelacakan', Pelacakan::class);
    Route::resource('laporan', LaporanController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('jenis-sampah', JenisSampahController::class);
    Route::resource('histori', HistoriAdmin::class);
    Route::resource('persetujuan', Persetujuan::class);
    Route::resource('laporan', ResponLaporan::class);
    Route::resource('print-data', PrintData::class);
});

Route::get('/', function () {
    return view('landing');
});

Route::get('/driver/dashboard', function () {
    return view('driver.dashboard');
})->name('driver.dashboard');
