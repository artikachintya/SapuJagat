<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResetPassword extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[!@#$%^&*(),.?":{}|<>]/',
                'confirmed',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'token.required' => __('request_reset.validation.token.required'),
            'email.required' => __('request_reset.validation.email.required'),
            'email.email' => __('request_reset.validation.email.email'),
            'password.required' => __('request_reset.validation.password.required'),
            'password.string' => __('request_reset.validation.password.string'),
            'password.min' => __('request_reset.validation.password.min'),
            'password.regex' => __('request_reset.validation.password.regex'),
            'password.confirmed' => __('request_reset.validation.password.confirmed'),
        ];
    }
}
