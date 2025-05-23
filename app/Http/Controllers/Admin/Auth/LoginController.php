<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class LoginController extends Controller
{
     public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        // dd('Admin login method reached');
        $credentials = $request->only('email', 'password');
        Log::info('Attempting login with:', $credentials);

        if (Auth::guard('admin')->attempt($credentials)) {
            Log::info('Admin login successful');
            return redirect()->route('admin.dashboard');
        }

        Log::warning('Admin login failed');
        return back()->withErrors(['email' => 'Invalid credentials']);
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
