<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\HistoriAdmin;
use App\Http\Controllers\Admin\JenisSampahController;
use App\Http\Controllers\Admin\Persetujuan;
use App\Http\Controllers\Admin\PrintData;
use App\Http\Controllers\Admin\ResponLaporan;

use App\Http\Controllers\Driver\PickUpController;
use App\Http\Controllers\Pengguna\Histori;
use App\Http\Controllers\Pengguna\LaporanController;
use App\Http\Controllers\Pengguna\Pelacakan;
use App\Http\Controllers\Pengguna\PenggunaController;
use App\Http\Controllers\Pengguna\TukarSampahController;
use App\Http\Controllers\Pengguna\TarikSaldoController;
use App\Http\Controllers\Pengguna\RatingController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\OtpController;

use App\Http\Controllers\HomeController;
// use App\Http\Controllers\TukarSampahController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Driver\DriverProfileController;
use App\Http\Controllers\Driver\HistoriDriver;
use App\Http\Controllers\ChatController;

// Public routes
// Route::get('/', function () {
//     return view('landing');
// });

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role == 1) {
            return redirect('/pengguna');
        } elseif ($user->role == 2) {
            return redirect('/admin');
        }
    }
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
// Route::get('/home', [HomeController::class, 'index'])->name('home');

// Satu callback untuk keduanya
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

//Buat Route otpnya
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');

//Route opt resend
Route::post('/otp/resend', [OtpController::class, 'resend'])->name('otp.resend');



// User Tukar Sampah
// user step 1 : tukar sampah

// user step 2 : ringkasan pesanan
// Route::get('/pengguna/ringkasan-pesanan', [TukarSampahController::class,'ringkasan'])->name('RingkasanPesanan2');
// Route::post('/pengguna/ringkasan-pesanan/jemput', [TukarSampahController::class,'jemput'])->name('ringkasan.jemput');

Route::prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/', [PenggunaController::class, 'index'])->name('dashboard');

    Route::resource('tarik-saldo', TarikSaldoController::class);
    Route::resource('tukar-sampah', TukarSampahController::class);
    Route::post('tukar-sampah/submit', [TukarSampahController::class, 'submit'])->name('tukar-sampah.submit');


    Route::get('ringkasan-pesanan', [TukarSampahController::class,'ringkasan'])->name('RingkasanPesanan2');
    Route::post('ringkasan-pesanan/jemput', [TukarSampahController::class,'jemput'])->name('ringkasan.jemput');

    Route::resource('histori', Histori::class);

    Route::resource('pelacakan', Pelacakan::class);
    Route::resource('laporan', LaporanController::class);

    Route::get('/profile', [ProfileController::class,'index'])->name('profile');
    Route::post('/profile/save', [ProfileController::class, 'save'])->name('profile.save');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/simpan-rating', [RatingController::class, 'simpan'])->name('simpan.rating');




});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('jenis-sampah', JenisSampahController::class);
    Route::resource('histori', HistoriAdmin::class);
    Route::resource('persetujuan', Persetujuan::class);
    Route::resource('laporan', ResponLaporan::class);
    Route::resource('print-data', PrintData::class);
    Route::get('profile', [AdminProfileController::class, 'index'])->name('profile');
    Route::get('profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile/save', [AdminProfileController::class, 'save'])->name('profile.save');

});


// Chat Routes
Route::prefix('pengguna')->group(function () {
    Route::get('/chat/{chat_id}', [ChatController::class, 'userChat'])->name('pengguna.chat');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('pengguna.chat.send');
});

Route::prefix('driver')->group(function () {
    Route::get('/chat/{chat_id}', [ChatController::class, 'driverChat'])->name('driver.chat');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('driver.chat.send');
    // Route::get('/chat/{chat_id}', [ChatController::class, 'userChat'])->name('pengguna.chat');
    // Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('pengguna.chat.send');

});

Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');

Route::prefix('driver')->name('driver.')->group(function () {
    Route::get('/', [PickUpController::class, 'index'])->name('dashboard');
    Route::get('profile', [DriverProfileController::class, 'index'])->name('profile');
    Route::get('profile/edit', [DriverProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile/save', [DriverProfileController::class, 'save'])->name('profile.save');
    Route::resource('histori', HistoriDriver::class);
});

// Add your routes here

// Add this route for updating pickup status
Route::post('/driver/pickup/{pickup}/update-status', [PickupController::class, 'updateStatus'])->name('driver.pickup.update-status');
Route::post('/driver/pickup/{pickup}/upload-proof', [PickupController::class, 'uploadProof'])->name('driver.pickup.upload-proof');

Route::post('/simpan-rating', [RatingController::class, 'simpan'])->name('simpan.rating');

