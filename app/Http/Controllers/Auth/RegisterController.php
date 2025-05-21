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
            'nama'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:8',
            'alamat'       => 'required|string|max:255',
            'provinsi'     => 'required|string|max:100',
            'kota'         => 'required|string|max:100',
            'kode_pos'     => 'required|digits_between:4,6',
            'nik'          => 'required|digits:16|unique:users,nik',
            'kode_negara'  => 'required|string',
            'telepon'      => 'required|digits_between:8,15',
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
            'name'      => $data['nama'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'alamat'    => $data['alamat'],
            'provinsi'  => $data['provinsi'],
            'kota'      => $data['kota'],
            'kode_pos'  => $data['kode_pos'],
            'nik'       => $data['nik'],
            'telepon'   => $data['kode_negara'] . $data['telepon'],
        ]);
    }
}
