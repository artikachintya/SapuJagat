<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pickup;
use Illuminate\Support\Facades\Auth;

class PickUpController extends Controller
{
    public function index()
    {
        $pickup = Pickup::where('user_id', Auth::id())  // Filter by current driver
              // Only unfinished pickups
            ->with([
                'order.user.info',                  // Load nested relationships
            ])
            ->first();

            // dd($pickup);
                                        // Get single record
        return view('driver.pickup', compact('pickup'));
    }

public function updateStatus(PickUp $pickup, Request $request)
{
    $request->validate([
        'status' => 'required|in:start_jemput,pick_up,arrival'
    ]);

    if ($request->status === 'start_jemput') {
        $pickup->start_time = now();
    } elseif ($request->status === 'pick_up') {
        $pickup->pick_up_date = now();
    } elseif ($request->status === 'arrival') {
        // Validate photo only for arrival status
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $pickup->arrival_date = now();

        // Handle file upload
        $path = $request->file('photo')->store('proofs', 'public');
        $pickup->photos = $path;
    }

    $pickup->save();

    return redirect()->back()->with('success', 'Status berhasil diperbarui');
}

public function uploadProof($id, Request $request)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $pickup = Pickup::findOrFail($id);

    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('proofs', 'public');
        $pickup->photos = $path;
        $pickup->arrival_date = now();
        // $pickup->status = 'completed';
        $pickup->save();

        // Add point to driver
        // $driver = $pickup->driver;
        // $driver->points += 1;
        // $driver->save();
    }
    dd($pickup);

    return redirect()->back()->with('success', 'Bukti pengantaran berhasil diupload!');
}
}
