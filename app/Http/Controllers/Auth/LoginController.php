<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\OtpMail;
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
        // Jangan hapus session jika sedang proses OTP
        if (!session()->has('otp_required')) {
            Session::forget(['otp_required', 'otp_user_id', 'otp_code', 'otp_expires_at']);
        }
    
        return view('auth.login');
    }

    /**
     * Menangani login yang berhasil
     */
    protected function authenticated(Request $request, $user)
    {
        $otp = random_int(100000, 999999);

        session([
            'otp_user_id' => $user->user_id,
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
            'otp_required' => true
        ]);

        \Mail::to($user->email)->send(new \App\Mail\OtpMail($otp));
        Auth::logout(); // agar belum langsung masuk dashboard

        return redirect()->route('login');
    }

}
