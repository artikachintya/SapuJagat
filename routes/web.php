<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\HistoriAdmin;
use App\Http\Controllers\Admin\JenisSampahController;
use App\Http\Controllers\Admin\PenugasanController;
use App\Http\Controllers\Admin\PersetujuanController;
use App\Http\Controllers\Admin\PrintDataController;
use App\Http\Controllers\Admin\ResponLaporan;

use App\Http\Controllers\Admin\UserListController;
use App\Http\Controllers\Driver\PickUpController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Pengguna\Histori;
use App\Http\Controllers\Pengguna\LaporanController;
use App\Http\Controllers\Pengguna\PelacakanController;
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
use Illuminate\Support\Facades\URL;

use App\Http\Middleware\AdminOnly;
use App\Http\Middleware\SetLanguageMiddleware;

// Public routes
// Route::get('/', function () {
//     return view('landing');
// });

Route::middleware(SetLanguageMiddleware::class)->group(function(){

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role == 1) {
            return redirect('/pengguna');
        } elseif ($user->role == 2) {
            return redirect('/admin');
        } elseif ($user->role == 3) {
            return redirect('/driver');
        }
    }
    return view('landing');
});

// Route::get('/pengguna/dashboard', function () {
//     return view('pengguna.dashboard');
// });

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

//Route otp resend
Route::post('/otp/resend', [OtpController::class, 'resend'])->name('otp.resend');

//Route otp cancel
Route::post('/otp/cancel', [OtpController::class, 'cancel'])->name('otp.cancel');

// User Tukar Sampah
// user step 1 : tukar sampah

// user step 2 : ringkasan pesanan
// Route::get('/pengguna/ringkasan-pesanan', [TukarSampahController::class,'ringkasan'])->name('RingkasanPesanan2');
// Route::post('/pengguna/ringkasan-pesanan/jemput', [TukarSampahController::class,'jemput'])->name('ringkasan.jemput');

Route::middleware(['auth', 'pengguna'])->prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/', [PenggunaController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [PenggunaController::class, 'index'])->name('dashboard');


    Route::resource('tarik-saldo', TarikSaldoController::class);
    Route::resource('tukar-sampah', TukarSampahController::class);
    Route::post('tukar-sampah/submit', [TukarSampahController::class, 'submit'])->name('tukar-sampah.submit');


    Route::get('ringkasan-pesanan', [TukarSampahController::class, 'ringkasan'])->name('RingkasanPesanan2');
    Route::post('ringkasan-pesanan/jemput', [TukarSampahController::class, 'jemput'])->name('ringkasan.jemput');

    Route::resource('histori', Histori::class);

    Route::resource('pelacakan', PelacakanController::class);
    Route::resource('laporan', LaporanController::class);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile/save', [ProfileController::class, 'save'])->name('profile.save');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/simpan-rating', [RatingController::class, 'simpan'])->name('simpan.rating');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('jenis-sampah', JenisSampahController::class);
    // soft delete
    Route::get('jenis-sampah-arsip', [JenisSampahController::class, 'archive'])->name('jenis-sampah.arsip');
    Route::post('jenis-sampah-restore/{id}', [JenisSampahController::class, 'restore'])->name('jenis-sampah.restore');
    // forcedelete
    Route::delete('jenis-sampah/{id}/force-delete', [JenisSampahController::class, 'forceDelete'])->name('jenis-sampah.force-delete');

    Route::resource('penugasan', PenugasanController::class);
    Route::resource('user-lists', UserListController::class);
    Route::get('user-lists/{id}/logs', [UserListController::class, 'showLog'])->name('user.logs');
    Route::get('penugasan-arsip', [PenugasanController::class, 'archive'])->name('penugasan.archive');
    Route::post('penugasan/{id}/restore', [PenugasanController::class, 'restore'])->name('penugasan.restore');
    Route::delete('penugasan/{id}/force', [PenugasanController::class, 'forceDelete'])->name('penugasan.forceDelete');

    Route::resource('histori', HistoriAdmin::class);
    Route::resource('persetujuan', PersetujuanController::class);
    Route::resource('laporan', ResponLaporan::class);
    Route::post('laporan/{report_id}/respond', [ResponLaporan::class, 'respond'])->name('laporan.respond');
    Route::resource('print-data', PrintDataController::class);
    Route::post('print-data/filter', [PrintDataController::class, 'filter'])->name('print-data.filter');
    Route::post('print-data/pdf', [PrintDataController::class, 'generatePdf'])->name('print-data.pdf');

    Route::get('print-data/pdf', function () {
        return redirect()->route('admin.print-data.index')
            ->with('error', 'Akses langsung ke halaman PDF tidak diperbolehkan.');
    });
    Route::post('/jenis-sampah/import', [JenisSampahController::class, 'import'])->name('jenis-sampah.import');

    Route::get('profile', [AdminProfileController::class, 'index'])->name('profile');
    Route::get('profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile/save', [AdminProfileController::class, 'save'])->name('profile.save');
});

// Chat Routes
Route::middleware(['auth', 'pengguna'])->prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/chat/{chat_id}', [ChatController::class, 'userChat'])->name('chat');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
});

Route::middleware(['auth', 'driver'])->prefix('driver')->name('driver.')->group(function () {
    // Route::get('/chat/{chat_id}', [ChatController::class, 'driverChat'])->name('chat');
    // Route::get('/chat/{chat_id}', [ChatController::class, 'driverChat'])->name('chat');
    Route::get('/chat/{chat_id}', [ChatController::class, 'driverChat'])
        ->name('chat')
        ->middleware(['signed']);

    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    // Route::get('/chat/{chat_id}', [ChatController::class, 'userChat'])->name('pengguna.chat');
    // Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('pengguna.chat.send');

});

Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');

Route::middleware(['auth', 'driver'])->prefix('driver')->name('driver.')->group(function () {
    Route::get('/', [PickUpController::class, 'index'])->name('dashboard');
    Route::get('profile', [DriverProfileController::class, 'index'])->name('profile');
    Route::get('profile/edit', [DriverProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile/save', [DriverProfileController::class, 'save'])->name('profile.save');
    Route::resource('histori', HistoriDriver::class);
    Route::get('/pickup/{id}', [PickupController::class, 'show'])->name('pickup.detail');
    Route::get('/chat', [ChatController::class, 'driverChatList'])->name('chat.list');

});

// Add this route for updating pickup status
Route::post('/driver/pickup/{pickup}/update-status', [PickupController::class, 'updateStatus'])->name('driver.pickup.update-status');
Route::post('/driver/pickup/{pickup}/upload-proof', [PickupController::class, 'uploadProof'])->name('driver.pickup.upload-proof');

Route::post('/simpan-rating', [RatingController::class, 'simpan'])->name('simpan.rating');


Route::post('/lang', LanguageController::class);

});

