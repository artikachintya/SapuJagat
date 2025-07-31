<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Spatie\Activitylog\Facades\LogActivity;
use Spatie\Activitylog\Models\Activity;

class OtpController extends Controller
{
    public function showOtpForm(Request $request)
    {
        if (!$request->session()->has('otp_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.otp');
    }
    
    // ✨ NEW METHOD: To handle cancellation of OTP
    public function cancel(Request $request)
    {
        $request->session()->forget([
            'otp_required',
            'otp_user_id',
            'otp_code',
            'otp_expires_at',
            'otp_verification'
        ]);
        return response()->json(['status' => 'success']);
    }

    public function resend(Request $request)
    {
        $userId = session('otp_user_id');
        $user = User::find($userId);

        if (!$user) {
            activity('authentication')
                ->withProperties([
                    'user_id' => $userId,
                    'ip' => $request->ip(),
                ])
                ->log('Gagal kirim ulang OTP: user tidak ditemukan');

            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        try {
            $otp = rand(100000, 999999);
            // ✨ CHANGE: Set expiry to a precise Carbon instance for the timer
            $expiresAt = now()->addSeconds(60);

            session([
                'otp_code' => $otp,
                'otp_expires_at' => $expiresAt
            ]);

            Mail::to($user->email)->send(new OtpMail($otp));

            activity('authentication')
                ->causedBy($user)
                ->withProperties([
                    'name' => $user->name,
                    'email' => $user->email,
                    'ip' => $request->ip(),
                ])
                ->log('OTP dikirim ulang');
            
            // ✨ CHANGE: Return the new expiration timestamp to the client
            return response()->json([
                'message' => 'OTP dikirim ulang',
                'expires_at' => $expiresAt->timestamp // Send as Unix timestamp
            ]);

        } catch (\Exception $e) {
            activity('authentication')
                ->withProperties([
                    'user_id' => $userId,
                    'email' => $user->email ?? 'unknown',
                    'ip' => $request->ip(),
                    'error' => $e->getMessage(),
                ])
                ->log('Gagal mengirim ulang OTP');

            Log::error('Gagal kirim ulang OTP: ' . $e->getMessage());
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
            activity('authentication')
                ->withProperties([
                    'user_id' => session('otp_user_id'),
                    'input_otp' => $request->otp,
                    'expired_at' => session('otp_expires_at'),
                    'ip' => $request->ip(),
                ])
                ->log('OTP verifikasi gagal');

            return back()->withErrors(['otp' => 'OTP salah atau kedaluwarsa.']);
        }

        $user = User::find(session('otp_user_id'));
        Auth::login($user);

        // ✨ CHANGE: Also forget otp_required
        session()->forget(['otp_user_id', 'otp_code', 'otp_expires_at', 'otp_required']);

        activity('authentication')
            ->causedBy($user)
            ->withProperties([
                'name' => $user->name,
                'email' => $user->email,
                'role' => 'user',
                'ip' => $request->ip(),
            ])
            ->log("Login berhasil setelah OTP oleh {$user->name}");

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