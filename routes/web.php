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

use App\Http\Controllers\Driver\DashboardController;

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

// user step 2 : ringkasan pesanan
// Route::get('/pengguna/ringkasan-pesanan', [TukarSampahController::class,'ringkasan'])->name('RingkasanPesanan2');
// Route::post('/pengguna/ringkasan-pesanan/jemput', [TukarSampahController::class,'jemput'])->name('ringkasan.jemput');

Route::prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/', [PenggunaController::class, 'index'])->name('dashboard');

    Route::resource('tukar-sampah', TukarSampahController::class);
    Route::post('tukar-sampah/submit', [TukarSampahController::class, 'submit'])->name('tukar-sampah.submit');
    
    Route::get('ringkasan-pesanan', [TukarSampahController::class,'ringkasan'])->name('RingkasanPesanan2');
    Route::post('ringkasan-pesanan/jemput', [TukarSampahController::class,'jemput'])->name('ringkasan.jemput');

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

Route::prefix('driver')->name('driver.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
