<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // In your ProfileController or UserController

public function index()
{
    $user = Auth::user();
    return view('pengguna.profile', compact('user'));
}

public function edit() {
    $user = Auth::user();
    return view('pengguna.edit-profile', compact('user'));
}

// protected function updateValidator(array $data, $userId)
// {
//     return Validator::make($data, [
//         'name'         => 'required|string|max:255',
//         'email'        => 'required|email:dns|unique:users,email,' . $userId . ',user_id',
//         'password'     => [
//             'nullable', // Optional during update
//             'min:8',
//             'regex:/[A-Z]/',
//             'regex:/[!@#$%^&*(),.?":{}|<>]/'
//         ],
//         'address'      => 'required|string|max:255',
//         'province'     => 'required|string|max:100',
//         'city'         => 'required|string|max:100',
//         'postal_code'  => 'required|digits_between:4,6',
//         'phone_num'    => 'required|digits_between:8,15',
//     ],
//     [
//         // Custom error messages (same as before)
//         'name.required'        => 'Nama lengkap wajib diisi.',
//         'email.required'       => 'Email wajib diisi.',
//         'email.email'          => 'Format email tidak valid.',
//         'email.unique'         => 'Email sudah terdaftar.',
//         'password.min'         => 'Kata sandi harus terdiri dari minimal 8 karakter dan mengandung setidaknya 1 huruf besar serta 1 karakter spesial.',
//         'password.regex'       => 'Kata sandi harus terdiri dari minimal 8 karakter dan mengandung setidaknya 1 huruf besar serta 1 karakter spesial.',
//         'address.required'     => 'Alamat wajib diisi.',
//         'province.required'    => 'Provinsi wajib dipilih.',
//         'city.required'        => 'Kota wajib dipilih.',
//         'postal_code.required' => 'Kode pos wajib diisi.',
//         'postal_code.digits_between' => 'Kode pos harus terdiri dari 4 hingga 6 digit.',
//         'phone_num.required'   => 'Nomor telepon wajib diisi.',
//         'phone_num.digits_between' => 'Nomor telepon harus terdiri dari 8 hingga 15 digit.'
//     ]);
// }



public function save(StoreUserProfileRequest $request)
{
    // ✅ Save user data
    $user = Auth::user();
    $user->name = $request->name;

    if ($request->filled('email')) {
        $user->email = $request->email;
    }
    $user->email = $request->email;
    if ($request->filled('phone_num')) {
        $user->phone_num = $request->phone_num;
    }

    if ($request->filled('NIK')) {
        $user->NIK = $request->NIK;
    }


    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    if ($request->hasFile('profile_pic')) {
        $path = $request->file('profile_pic')->store('profile_pictures', 'public');
        $user->profile_pic = $path;
    }

    $user->save();

    // ✅ Update user info
    $info = $user->info ?? new \App\Models\UserInfo();
    $info->user_id = $user->user_id;

    if (!$user->info) {
        $info->balance = 0;
    }

    $info->address     = $request->address;
    $info->city        = $request->city;
    $info->province    = $request->province;
    $info->postal_code = $request->postal_code;
    $info->save();

    return redirect()->route('pengguna.profile')->with('success', 'Profil berhasil diperbarui.');
}


}

