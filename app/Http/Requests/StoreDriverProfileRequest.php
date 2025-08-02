<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email:dns|unique:users,email',
            'password' => [
                'required',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[!@#$%^&*(),.?":{}|<>]/'
            ],
            'NIK' => 'required|digits:16|unique:users,nik',
            'phone_num' => 'required|digits_between:8,15|unique:users,phone_num',
            'license_plate'  => 'required|string|max:10',
            'profile_pic'    => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ];
    }

    public function message(): array
    {
        return [
            'name.required' => __('request_register.validation.name.required'),
            'name.max' => __('request_register.validation.name.max'),
            'email.required' => __('request_register.validation.email.required'),
            'email.email' => __('request_register.validation.email.email'),
            'email.unique' => __('request_register.validation.email.unique'),
            'password.required' => __('request_register.validation.password.required'),
            'password.min' => __('request_register.validation.password.min'),
            'password.regex' => __('request_register.validation.password.regex'),
            'NIK.required' => __('request_register.validation.NIK.required'),
            'NIK.digits' => __('request_register.validation.NIK.digits'),
            'NIK.unique' => __('request_register.validation.NIK.unique'),
            'phone_num.required' => __('request_register.validation.phone_num.required'),
            'phone_num.digits_between' => __('request_register.validation.phone_num.digits_between'),
            'phone_num.unique' => __('request_register.validation.phone_num.unique'),
            'license_plate.required' => 'Nomor plat wajib diisi.',
            'license_plate.string' => 'Nomor plat harus berupa teks.',
            'license_plate.max' => 'Nomor plat maksimal 10 karakter.',
            'profile_pic.image' => 'File foto profil harus berupa gambar.',
            'profile_pic.mimes' => 'Format gambar harus jpeg, jpg, png, atau webp.',
            'profile_pic.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
