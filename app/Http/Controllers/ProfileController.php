<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

public function save(Request $request)
{
    // dd($request);
    $user = Auth::user();
    $user->name = $request->name;
    $user->NIK = $request->NIK;
    $user->email = $request->email;
    $user->phone_num = $request->phone_num;

    if ($request->filled('password')) {
    $user->password = Hash::make($request->password);
}
    if ($request->hasFile('profile_pic')) {
        $path = $request->file('profile_pic')->store('profile_pictures', 'public');
        $user->profile_pic = $path;
    }

    $user->save();

    // Update or create the related user info
    $info = $user->info ?? new \App\Models\UserInfo();
    $info->user_id = $user->user_id; // make sure this matches your key
    if (!$user->info) {
        $info->balance = 0;
    }
    $info->address = $request->address;
    $info->city = $request->city;
    $info->province = $request->province;
    $info->postal_code = $request->postal_code;
    $info->save();

    return redirect()->route('pengguna.profile');
}

}

