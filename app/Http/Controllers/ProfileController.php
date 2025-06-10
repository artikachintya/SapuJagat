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
    $user = Auth::user();
    $user->name = $request->name;
    $user->NIK = $request->NIK;
    $user->email = $request->email;
    $user->phone_num = $request->phone_num;

    $user->info->address = $request->address;
    $user->info->city = $request->city;
    $user->info->province = $request->province;
    $user->info->save();
    // dd($request->profile_pic);
    if ($request->hasFile('profile_pic')) {
        $path = $request->file('profile_pic')->store('profile_pictures', 'public');
        $user->profile_pic = $path;
    }

    $user->save();

    return redirect()->route('pengguna.profile');
}

}

