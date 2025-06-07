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
    // public function redirectToGoogle(Request $request)
    // {
    //     // Simpan mode (login atau register)
    //     Session::put('google_auth_mode', $request->query('mode', 'login'));
    //     return Socialite::driver('google')->stateless()->redirect();
    // }

    public function redirectToGoogle(Request $request)
    {
        $mode = $request->query('mode', 'login');

        // Simpan mode di "state" untuk dibawa balik di callback
        $redirectUrl = Socialite::driver('google')
            ->stateless()
            ->with(['state' => $mode])
            ->redirect();

        return $redirectUrl;
    }

    // public function handleGoogleCallback()
    // {
    //     $googleUser = Socialite::driver('google')->stateless()->user();
    //     $mode = Session::pull('google_auth_mode', 'login'); // Tarik dan hapus dari session

    //     $user = User::where('email', $googleUser->email)->first();

    //     if ($mode === 'register') {
    //         if ($user) {
    //             return redirect()->route('login')->with('error', 'Email ini sudah terdaftar, silakan login.');
    //         }

    //         $user = User::create([
    //             'name' => $googleUser->name,
    //             'email' => $googleUser->email,
    //             'password' => bcrypt(Str::random(16)),
    //             'email_verified_at' => now(),
    //             'role' => 1,
    //             'NIK' => null,
    //             'phone_num' => null,
    //             'is_google_user' => true
    //         ]);

    //         // Redirect ke login dengan pesan sukses
    //         return redirect()->route('login')->with('success', 'Email berhasil terdaftar. Silakan login untuk melanjutkan.');
    //     }

    //     if (!$user) {
    //         return redirect()->route('login')->with('error', 'Email Google Anda belum terdaftar.');
    //     }

    //     Auth::login($user);
    //     return redirect()->intended('/pengguna');
    // }

    // public function handleGoogleCallback()
    // {
    //     $googleUser = Socialite::driver('google')->stateless()->user();
    //     $mode = Session::pull('google_auth_mode', 'login'); // Tarik dan hapus dari session

    //     $user = User::where('email', $googleUser->email)->first();

    //     if (!$user) {
    //         if ($mode === 'register') {
    //             $user = User::create([
    //                 'name' => $googleUser->name,
    //                 'email' => $googleUser->email,
    //                 'password' => bcrypt(Str::random(16)),
    //                 'email_verified_at' => now(),
    //                 'role' => 1,
    //                 'NIK' => null,
    //                 'phone_num' => null,
    //                 'is_google_user' => true
    //             ]);

    //             return redirect()->route('login')->with('success', 'Email berhasil terdaftar. Silakan login untuk melanjutkan.');
    //         } else {
    //             return redirect()->route('login')->with('error', 'Email Google Anda belum terdaftar.');
    //         }
    //     }

    //     // Jika user sudah ada, langsung login
    //     Auth::login($user);
    //     return redirect()->intended('/pengguna');
    // }

    public function handleGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $mode = $request->query('state', 'login');

        $user = User::where('email', $googleUser->email)->first();

        if ($user) {
            if ($mode === 'register') {
                // Email sudah terdaftar saat daftar, jangan login
                return redirect()->route('login')->with('error', 'Email ini sudah terdaftar, silakan login.');
            }

            // Jika mode login, cek apakah user memang dari Google
            if (!$user->is_google_user) {
                return redirect()->route('login')->with('error', 'Email ini terdaftar tidak dengan akun google. Silakan login dengan email dan password.');
            }

            // Login user Google
            Auth::login($user);
            return redirect()->intended('/pengguna');
        }

        // Kalau user belum ada, tapi mode daftar, buat akun
        if ($mode === 'register') {
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(Str::random(16)),
                'email_verified_at' => now(),
                'role' => 1,
                'NIK' => null,
                'phone_num' => null,
                'is_google_user' => true
            ]);

            return redirect()->route('login')->with('success', 'Email berhasil terdaftar. Silakan login untuk melanjutkan.');
        }

        // Kalau user belum ada dan mode login, tampilkan error
        return redirect()->route('login')->with('error', 'Email Google Anda belum terdaftar.');
    }

}
