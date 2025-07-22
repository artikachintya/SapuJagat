<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'address' => 'required|string|max:255',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|digits_between:4,6',
            'NIK' => 'required|digits:16|unique:users,nik',
            'phone_num' => 'required|digits_between:8,15|unique:users,phone_num'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi harus minimal 8 karakter.',
            'password.regex' => 'Kata sandi harus mengandung huruf besar dan karakter spesial.',
            'address.required' => 'Alamat wajib diisi.',
            'province.required' => 'Provinsi wajib dipilih.',
            'city.required' => 'Kota wajib dipilih.',
            'postal_code.required' => 'Kode pos wajib diisi.',
            'postal_code.digits_between' => 'Kode pos harus 4–6 digit.',
            'NIK.required' => 'NIK wajib diisi.',
            'NIK.digits' => 'NIK harus terdiri dari 16 digit.',
            'NIK.unique' => 'NIK ini sudah terdaftar.',
            'phone_num.required' => 'Nomor telepon wajib diisi.',
            'phone_num.digits_between' => 'Nomor telepon harus 8–15 digit.',
            'phone_num.unique' => 'Nomor telepon ini sudah digunakan.'
        ];
    }
}
