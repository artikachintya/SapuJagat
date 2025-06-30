<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function edit() {
        $user = Auth::user();
        return view('admin.edit-profile', compact('user'));
    }

    public function save(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->NIK = $request->NIK;
        $user->email = $request->email;
        $user->phone_num = $request->phone_num;

        if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

        // dd($request->profile_pic);
        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')->store('profile_pictures', 'public');
            $user->profile_pic = $path;
        }

        $user->save();

        return redirect()->route('admin.profile');
    }

}
