<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pickup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PickUpController extends Controller
{
    public function index()
    {
        // $pickup = Pickup::where('user_id', Auth::id())  // Filter by current driver
        //       // Only unfinished pickups
        //     ->with([
        //         'order.user.info', 'order.penugasan'                 // Load nested relationships
        //     ])
        //     ->first();

        //     // dd($pickup);
        //                                 // Get single record
        // return view('driver.pickup', compact('pickup'));

        $driverId = Auth::id(); // Ambil ID user yang sedang login

        // $pickupTasks = DB::table('penugasans as p')
        //     ->join('orders as o', 'p.order_id', '=', 'o.order_id')
        //     ->join('users as u', 'o.user_id', '=', 'u.user_id')
        //     ->join('order_details as od', 'o.order_id', '=', 'od.order_id')
        //     ->where('p.user_id', $driverId)
        //     ->whereNull('o.status')
        //     ->select(
        //         'o.order_id',
        //         'o.date_time_request',
        //         'u.name as customer_name',
        //         'od.trash_id',
        //         'od.quantity'
        //     )
        //     ->get();

            // dd($pickupTasks);


    $pickups = PickUp::with(['order.user']) // Load related order and user
        ->where('user_id', $driverId)
        ->whereNull('arrival_date') // Only where arrival_time/date is null
        ->get();

        dd($pickups);


             return view('driver.pickup', compact('$pickup'));
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
