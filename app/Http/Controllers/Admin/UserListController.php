<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserStatusRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class UserListController extends Controller
{
    /**
     * Tampilkan daftar semua akun user, driver, dan admin.
     */
    public function index()
    {
        $users = User::where('role', 1)->get();
        $drivers = User::where('role', 3)->get();
        $admins = User::where('role', 2)->get();

        return view('admin.user-lists', compact('users', 'drivers', 'admins'));
    }

    /**
     * Update status user.
     */
    public function update(UpdateUserStatusRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->status = $request->status;
        $user->save();

        return redirect()->back()->with('success', __('success.update_user'));
    }

    /**
     * Tampilkan log aktivitas user tertentu berdasarkan ID.
     */


    public function showLog($id)
    {
        $user = User::findOrFail($id);

        $logs = Activity::where('causer_type', User::class)
            ->where('causer_id', $user->user_id) // gunakan $user->user_id, bukan hanya $id
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.user-logs', compact('logs', 'user'));
    }

}
