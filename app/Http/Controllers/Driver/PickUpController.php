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

    $driverId = Auth::id(); // Ambil ID user yang sedang login

    $pickups = PickUp::with(['order.user']) // Load related order and user
        ->where('user_id', $driverId)
        ->whereNull('arrival_date') // Only where arrival_time/date is null
        ->get();

        // dd($pickup);


        return view('driver.list-pickup', compact('pickups'));
    }

    public function show($id) {
         $pickup = PickUp::with(['order.user.info'])
        ->where('pick_up_id', $id)
        ->firstOrFail();

        return view('driver.pickup', compact('pickup'));
    }

// public function updateStatus(PickUp $pickup, Request $request)
// {
//     $request->validate([
//         'status' => 'required|in:start_jemput,pick_up,arrival'
//     ]);

//     if ($request->status === 'start_jemput') {
//         $pickup->start_time = now();
//     } elseif ($request->status === 'pick_up') {
//         $pickup->pick_up_date = now();
//     } elseif ($request->status === 'arrival') {
//         // Validate photo only for arrival status
//         $request->validate([
//             'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//         ]);

//         $pickup->arrival_date = now();

//         // Handle file upload
//         $path = $request->file('photo')->store('proofs', 'public');
//         $pickup->photos = $path;
//     }

//     $pickup->save();

//     return redirect()->back()->with('success', 'Status berhasil diperbarui');
// }


// public function updateStatus(PickUp $pickup, Request $request)
// {
//     $request->validate([
//         'status' => 'required|in:start_jemput,pick_up,arrival'
//     ]);

//     if ($request->status === 'start_jemput') {
//         $pickup->start_time = now();

//     } elseif ($request->status === 'pick_up') {
//         $pickup->pick_up_date = now();

//     } elseif ($request->status === 'arrival') {
//         // 1. Validate & upload photo
//         $request->validate([
//             'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//         ]);

//         $pickup->arrival_date = now();

//         $path = $request->file('photo')->store('proofs', 'public');
//         $pickup->photos = $path;

//         // 2. Update related Penugasan status to "completed" (1)
//         DB::table('penugasans')
//             ->where('order_id', $pickup->order_id)
//             ->where('user_id', $pickup->user_id)
//             ->update(['status' => 1, 'updated_at' => now()]);
//     }

//     $pickup->save();

//     // 3. Redirect to pickup list with flash data for modal
//     return redirect()
//     ->route('driver.pickup.detail', $pickup->pick_up_id) // ✅ go back to detail
//     ->with('finished', true);                             // ✅ trigger modal

// }


// public function updateStatus(PickUp $pickup, Request $request)
// {
//     dd($request);
//     $request->validate([
//         'status' => 'required|in:start_jemput,pick_up,arrival'
//     ]);
//     if ($request->status === 'start_jemput') {
//         $pickup->start_time = now();
//     } elseif ($request->status === 'pick_up') {
//         $pickup->pick_up_date = now();
//     } elseif ($request->status === 'arrival') {

//         dd($request);
//         // 1. Validate & upload photo
//         $request->validate([
//             'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//         ]);

//         $pickup->arrival_date = now();
//         $path = $request->file('photo')->store('proofs', 'public');
//         $pickup->photos = $path;

//         // 2. Update related Penugasan status to "completed"
//         DB::table('penugasans')
//             ->where('order_id', $pickup->order_id)
//             ->where('user_id', $pickup->user_id)
//             ->update(['status' => 1, 'updated_at' => now()]);

//         $pickup->save();

//         // ✅ Only trigger modal + redirect if arrival
//         return redirect()
//             ->route('driver.pickup.detail', $pickup->pick_up_id)
//             ->with('finished', true);
//     }

//     $pickup->save();

//     // ✅ Regular redirect without modal
//     return redirect()
//         ->route('driver.pickup.detail', $pickup->pick_up_id);
// }

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
        // Validasi & Upload foto
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan waktu tiba
        $pickup->arrival_date = now();

        // Simpan foto ke storage
        $path = $request->file('photo')->store('proofs', 'public');
        $pickup->photos = $path;

        // Tandai penugasan selesai
        DB::table('penugasans')
            ->where('order_id', $pickup->order_id)
            ->where('user_id', $pickup->user_id)
            ->update([
                'status' => 1,
                // 'updated_at' => now()
            ]);
    }

    $pickup->save();

    // Tampilkan popup "selesai" hanya jika status arrival
    if ($request->status === 'arrival') {
        return redirect()
            ->route('driver.pickup.detail', $pickup->pick_up_id)
            ->with('finished', true);
    }

    // Untuk status lain, hanya reload halaman detail tanpa popup
    return redirect()->route('driver.pickup.detail', $pickup->pick_up_id);
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
    }
    dd($pickup);

    return redirect()->back()->with('success', 'Bukti pengantaran berhasil diupload!');
}
}
