<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Activitylog\Facades\LogActivity;
use Spatie\Activitylog\Models\Activity;

class GoogleController extends Controller
{
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

    public function handleGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $mode = $request->query('state', 'login');

        $user = User::where('email', $googleUser->email)->first();

        if ($user) {
            if ($mode === 'register') {
                return redirect()->route('login')->with('error', __('success.alerts.already_registered'));
            }

            if (!$user->is_google_user) {
                activity('authentication')
                    ->causedBy($user)
                    ->withProperties([
                        'email' => $user->email,
                        'reason' => 'not a google user',
                        'ip' => $request->ip(),
                    ])
                    ->log("Gagal login Google: {$user->name} bukan pengguna Google");

                return redirect()->route('login')->with(__('success.alerts.non_google_account'));
            }

            Auth::login($user);

            // ✅ Logging login Google
            activity('authentication')
                ->causedBy($user)
                ->withProperties([
                    'role' => 'user',
                    'method' => 'google-oauth',
                    'name' => $user->name,
                    'ip' => $request->ip(),
                ])
                ->log("Login dengan Google oleh {$user->name} (user)");

            return redirect()->intended('/pengguna');
        }

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

            return redirect()->route('login')->with('success', __('success.alerts.registration_success'));
        }

        activity('authentication')
            ->withProperties([
                'email' => $googleUser->getEmail(),
                'reason' => 'google account not registered',
                'ip' => $request->ip(),
            ])
            ->log("Gagal login Google: akun belum terdaftar ({$googleUser->getEmail()})");

        return redirect()->route('login')->with('error', __('success.alerts.not_registered'));
    }



}
