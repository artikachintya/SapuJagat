<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function redirectTo()
    {
        return '/pengguna';
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    public function showLoginForm()
    {
        // Hapus semua session OTP saat membuka login (kecuali saat redirect setelah submit OTP)
        if (!session()->has('otp_verification')) {
            Session::forget(['otp_required', 'otp_user_id', 'otp_code', 'otp_expires_at']);
        }
            return view('auth.login');
    }

    /**
     * Menangani login yang berhasil
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->role == 1) {
        // Jika role = 1 (pengguna biasa), kirim OTP
            $otp = random_int(100000, 999999);

            session([
                'otp_user_id' => $user->user_id,
                'otp_code' => $otp,
                'otp_expires_at' => now()->addMinutes(1),
                'otp_required' => true,
                'otp_verification' => true
            ]);

            Mail::to($user->email)->send(new \App\Mail\OtpMail($otp));
            Auth::logout(); // logout sementara hingga OTP diverifikasi

            return redirect()->route('login');
        }

    // Jika bukan role 1 (admin/driver), langsung masuk
        if ($user->role == 2) {
            return redirect()->intended('dashboard');
        } elseif ($user->role == 3) {
            return redirect()->intended('/driver');
        }
    }
}
