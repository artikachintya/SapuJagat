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
    // $validated = $request->validated();
    $user = Auth::user();

    // Update basic user fields
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone_num = $request->phone_num;

    if ($request->filled('NIK')) {
        $user->NIK = $request->NIK;
    }

    // Update or create license record
    if ($user->license) {
        // License sudah ada, update
        $user->license->license_plate = $request->license_plate;
        $user->license->save();
    } else {
        // License belum ada, create baru
        $user->license()->create([
            'license_plate' => $request->license_plate,
        ]);
    }

    // Update profile picture if uploaded
    if ($request->hasFile('profile_pic')) {
        $path = $request->file('profile_pic')->store('profile_pictures', 'public');
        $user->profile_pic = $path;
    }

    $user->save();

    return redirect()->route('driver.profile')->with('success', 'Profile updated successfully!');
}

}
