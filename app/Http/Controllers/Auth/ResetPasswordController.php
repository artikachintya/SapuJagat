<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    protected function rules()
    {

        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8', // minimal 8 karakter
                'regex:/[A-Z]/', // harus mengandung huruf kapital
                'regex:/[!@#$%^&*(),.?":{}|<>]/', // harus mengandung karakter spesial
                'confirmed', // cocok dengan konfirmasi password
            ],

        ];
    }
    protected function validationErrorMessages()
    {
        return [
            'password.regex' => 'Password harus mengandung minimal satu huruf kapital dan satu karakter spesial.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password harus minimal 8 karakter.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
        ];
    }
}

