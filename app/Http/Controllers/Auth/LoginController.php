<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Facades\LogActivity;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;

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

    protected function loggedOut(Request $request)
    {
        return redirect('/login');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            activity('authentication')
                ->withProperties([
                    'email' => $email,
                    'reason' => 'email not found',
                    'ip' => $request->ip(),
                ])
                ->log("Gagal login: Email tidak ditemukan ($email)");
        } else {
            activity('authentication')
                ->causedBy($user)
                ->withProperties([
                    'email' => $email,
                    'reason' => 'invalid password',
                    'ip' => $request->ip(),
                ])
                ->log("Gagal login: Password salah untuk {$user->name}");
        }

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')]
        ]);
    }

    public function showLoginForm()
    {
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
        // Jika role = 1 (pengguna biasa), kirim OTP
        if ($user->role == 1) {
            $otp = random_int(100000, 999999);

            session([
                'otp_user_id' => $user->user_id,
                'otp_code' => $otp,
                'otp_expires_at' => now()->addMinutes(1),
                'otp_required' => true,
                'otp_verification' => true,
                'remember_me' => $request->has('remember'),
            ]);

            Mail::to($user->email)->send(new \App\Mail\OtpMail($otp));
            Auth::logout(); // logout sementara hingga OTP diverifikasi

            return redirect()->route('login');
        }

        activity('authentication')
            ->causedBy($user)
            ->withProperties([
                'role' => $this->getRoleName($user->role),
                'method' => 'email-password',
                'name' => $user->name,
                'ip' => $request->ip(),
            ])
            ->log("Login berhasil sebagai {$user->name} ({$this->getRoleName($user->role)})");


        // Redirect sesuai role
        if ($user->role == 1) {
            return redirect()->intended('/pengguna');
        } elseif ($user->role == 2) {
            return redirect()->intended('/admin');
        } elseif ($user->role == 3) {
            return redirect()->intended('/driver');
        }
    }

    /**
     * Mengembalikan nama role dari nilai numerik
     */
    private function getRoleName($role)
    {
        return match ($role) {
            1 => 'user',
            2 => 'admin',
            3 => 'driver',
            default => 'unknown',
        };
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        // Logging sebelum logout
        activity('authentication')
            ->causedBy($user)
            ->withProperties([
                'role' => $this->getRoleName($user->role ?? 1),
                'name' => $user->name,
                'ip' => $request->ip(),
            ])
            ->log("Logout oleh {$user->name} ({$this->getRoleName($user->role ?? 1)})");

        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

}
