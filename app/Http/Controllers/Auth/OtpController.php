<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class OtpController extends Controller
{
    public function showOtpForm(Request $request)
    {
        if (!$request->session()->has('otp_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.otp');
    }

    public function resend(Request $request)
    {
        $userId = session('otp_user_id');
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        try {
            $otp = rand(100000, 999999);

            session([
                'otp_code' => $otp,
                'otp_expires_at' => now()->addMinutes(1)
            ]);

            \Mail::to($user->email)->send(new \App\Mail\OtpMail($otp));

            return response()->json(['message' => 'OTP dikirim ulang']);
        } catch (\Exception $e) {
            \Log::error('Gagal kirim ulang OTP: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengirim ulang OTP'], 500);
        }
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        if (
            session('otp_code') != $request->otp ||
            now()->gt(session('otp_expires_at'))
        ) {
            return back()->withErrors(['otp' => 'OTP salah atau kedaluwarsa.']);
        }

        // Login kembali user
        $user = User::find(session('otp_user_id'));
        Auth::login($user);

        // Bersihkan session OTP
        session()->forget(['otp_user_id', 'otp_code', 'otp_expires_at']);

        switch ($user->role) {
            case 1:
                return redirect('/pengguna');
            case 2:
                return redirect('admin/dashboard');
            case 3:
                return redirect('/driver');
            default:
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role tidak dikenali.');
        }
    }
}
