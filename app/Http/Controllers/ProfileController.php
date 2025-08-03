<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;

class ProfileController extends Controller
{

public function index()
{
    $user = Auth::user();
    return view('pengguna.profile', compact('user'));
}

public function edit() {
    $user = Auth::user();
    return view('pengguna.edit-profile', compact('user'));
}


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

    return redirect()->route('pengguna.profile')->with('success', __('success.profile'));
}


}

