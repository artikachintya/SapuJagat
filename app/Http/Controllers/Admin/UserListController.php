<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreReportResponseRequest;
use App\Http\Requests\UpdateUserStatusRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Report;
use Response;

class UserListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', 1)->get();
        $drivers = User::where('role', 3)->get();
        $admins = User::where('role', 2)->get();
        
        return view('admin.user-lists', compact('users','drivers','admins'));
    }

    public function update(UpdateUserStatusRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->status = $request->status;
        $user->save();

        return redirect()->back()->with('success', 'User status updated.');
    }

}
