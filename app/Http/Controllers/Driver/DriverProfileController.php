<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDriverProfileRequest;
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

public function save(StoreDriverProfileRequest $request)
{
    $user = Auth::user();

    $user->name = $request->name;

     if ($request->filled('phone_num')) {
        $user->phone_num = $request->phone_num;
    }
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    if ($request->hasFile('profile_pic')) {
        $path = $request->file('profile_pic')->store('profile_pictures', 'public');
        $user->profile_pic = $path;
    }

    $user->save();

    if ($request->filled('license_plate')) {
        if ($user->license) {
            $user->license->update([
                'license_plate' => $request->license_plate,
            ]);
        } else {
            $user->license()->create([
                'license_plate' => $request->license_plate,
            ]);
        }
    }


    return redirect()->route('driver.profile')->with('success', 'Profile updated successfully!');
}


}
