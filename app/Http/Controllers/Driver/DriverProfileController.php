<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverProfileController extends Controller
{
    public function index()
{
    $user = Auth::user();
    return view('driver.profile', compact('user'));
}

public function edit() {
    $user = Auth::user();
    return view('driver.edit-profile', compact('user'));
}

public function save(Request $request)
{
    $user = Auth::user();
    $user->name = $request->name;

    $user->email = $request->email;
    $user->phone_num = $request->phone_num;

    if ($request->filled('NIK')) {
             $user->NIK = $request->NIK;
     }
    $user->license->license_plate = $request->license_plate;
    $user->license->save();
    // dd($request->profile_pic);
    if ($request->hasFile('profile_pic')) {
        $path = $request->file('profile_pic')->store('profile_pictures', 'public');
        $user->profile_pic = $path;
    }

    $user->save();

    return redirect()->route('driver.profile');
}

}
