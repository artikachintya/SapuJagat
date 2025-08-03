<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(StoreRegisterRequest $request)
    {
        $validated = $request->validated();

        try {
            event(new Registered($user = $this->create($validated)));

            activity('authentication')
                ->causedBy($user)
                ->withProperties([
                    'email' => $user->email,
                    'ip' => $request->ip()
                ])
                ->log('User berhasil mendaftar akun');

            return redirect($this->redirectPath())->with('success', __('success.alerts.success'));
        } catch (\Exception $e) {
            activity('authentication')
                ->withProperties([
                    'email' => $validated['email'] ?? null,
                    'ip' => $request->ip(),
                    'error' => $e->getMessage(),
                ])
                ->log('User gagal mendaftar akun');

            return redirect()->back()->withErrors(['register' => __('success.alerts.error')]);
        }
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'],
            'province' => $data['province'],
            'city' => $data['city'],
            'postal_code' => $data['postal_code'],
            'NIK' => $data['NIK'],
            'phone_num' => $data['phone_num'],
            'role' => 1,
            'email_verified_at' => now(),
        ]);

        UserInfo::create([
            'user_id' => $user->user_id, // Lebih aman daripada User::latest()
            'address' => $data['address'],
            'province' => $data['province'],
            'city' => $data['city'],
            'postal_code' => $data['postal_code'],
            'balance' => 0,
        ]);

        return $user;
    }
}
