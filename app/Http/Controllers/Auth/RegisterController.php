<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'         => 'required|string|max:255',
            'email'        => 'required|email:dns|unique:users,email',
            'password'     => [
                'required',
                'min:8',
                'regex:/[A-Z]/',            // Harus ada 1 huruf besar
                'regex:/[!@#$%^&*(),.?":{}|<>]/' // Harus ada 1 karakter spesial
            ],
            'address'      => 'required|string|max:255',
            'province'     => 'required|string|max:100',
            'city'         => 'required|string|max:100',
            'postal_code'  => 'required|digits_between:4,6',
            'NIK'          => 'required|digits:16|unique:users,nik',
            'phone_num'    => 'required|digits_between:8,15',
        ],
        [
            // Custom error messages
            'name.required'        => 'Nama lengkap wajib diisi.',
            'email.required'       => 'Email wajib diisi.',
            'email.email'          => 'Format email tidak valid.',
            'email.unique'         => 'Email sudah terdaftar.',
            'password.required'    => 'Kata sandi wajib diisi.',
            'password.min'         => 'Kata sandi harus terdiri dari minimal 8 karakter dan mengandung setidaknya 1 huruf besar serta 1 karakter spesial.',
            'password.regex'       => 'Kata sandi harus terdiri dari minimal 8 karakter dan mengandung setidaknya 1 huruf besar serta 1 karakter spesial.',
            'address.required'     => 'Alamat wajib diisi.',
            'province.required'    => 'Provinsi wajib dipilih.',
            'city.required'        => 'Kota wajib dipilih.',
            'postal_code.required' => 'Kode pos wajib diisi.',
            'postal_code.digits_between' => 'Kode pos harus terdiri dari 4 hingga 6 digit.',
            'NIK.required'         => 'NIK wajib diisi.',
            'NIK.digits'           => 'NIK harus terdiri dari 16 digit.',
            'NIK.unique'           => 'NIK ini sudah terdaftar.',
            'phone_num.required'   => 'Nomor telepon wajib diisi.',
            'phone_num.digits_between' => 'Nomor telepon harus terdiri dari 8 hingga 15 digit.'
        ],
        [
            // Attribute aliasing
            'NIK' => 'NIK',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'password'     => Hash::make($data['password']),
            'address'      => $data['address'],
            'province'     => $data['province'],
            'city'         => $data['city'],
            'postal_code'  => $data['postal_code'],
            'NIK'          => $data['NIK'],
            'phone_num'    => $data['phone_num'],
        ]);
    }
}
