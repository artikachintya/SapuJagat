<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        Session::put('google_auth_mode', $request->query('mode', 'login'));
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $mode = Session::pull('google_auth_mode', 'login');

        $user = User::where('email', $googleUser->email)->first();

        if ($mode === 'register') {
            if ($user) {
                return redirect()->route('login')->with('error', 'Email ini sudah terdaftar, silakan login.');
            }

            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(Str::random(16)),
                'email_verified_at' => now(),
                'role' => 1,
                'NIK' => null, // jika kamu izinkan nullable
                'phone_num' => null,
            ]);

            Auth::login($user);
            return redirect()->intended('/pengguna');
        }

        if (!$user) {
            return redirect()->route('login')->with('error', 'Email Google Anda belum terdaftar.');
        }

        Auth::login($user);
        return redirect()->intended('/pengguna');
    }
}
