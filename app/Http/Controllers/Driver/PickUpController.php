<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePickUpRequest;
use App\Models\Penugasan;
use Illuminate\Http\Request;
use App\Models\Pickup;
use App\Models\Chat;
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

        $pickup = PickUp::with(['order.user.info'])->where('pick_up_id', $id)->firstOrFail();

        $chat = null;
        if ($pickup->order && $pickup->order->user_id) {
            $driverId = Auth::id();
            $userId = $pickup->order->user_id;

            $chat = Chat::firstOrCreate(
                    ['user_id' => $userId, 'driver_id' => $driverId],
                    ['date_time_created' => now()]
                );
        }

        return view('driver.pickup', compact('pickup', 'chat'));
    }

public function updateStatus(PickUp $pickup, StorePickUpRequest $request)
{
    $driver = Auth::user(); // Ambil driver yang login

    if ($request->status === 'start_jemput') {
        $pickup->start_time = now();
        $pickup->save();

        activity('update_pickup')
            ->causedBy($driver)
            ->performedOn($pickup)
            ->withProperties([
                'pickup_id' => $pickup->pick_up_id,
                'order_id' => $pickup->order_id,
                'status' => 'start_jemput',
            ])
            ->log("Driver {$driver->name} memulai penjemputan untuk order ID {$pickup->order_id}.");

    } elseif ($request->status === 'pick_up') {
        $pickup->pick_up_date = now();
        $pickup->save();

        activity('update_pickup')
            ->causedBy($driver)
            ->performedOn($pickup)
            ->withProperties([
                'pickup_id' => $pickup->pick_up_id,
                'order_id' => $pickup->order_id,
                'status' => 'pick_up',
            ])
            ->log("Driver {$driver->name} mengambil sampah dari order ID {$pickup->order_id}.");

    } elseif ($request->status === 'arrival') {

        $pickup->arrival_date = now();
        $path = $request->file('photo')->store('proofs', 'public');
        $pickup->photos = $path;
        $pickup->notes = $request->notes;
        $pickup->save();

        // Update status penugasan jadi selesai
        Penugasan::where('order_id', $pickup->order_id)
            ->where('user_id', $pickup->user_id)
            ->update(['status' => 1]);

        activity('update_pickup')
            ->causedBy($driver)
            ->performedOn($pickup)
            ->withProperties([
                'pickup_id' => $pickup->pick_up_id,
                'order_id' => $pickup->order_id,
                'status' => 'arrival',
                'photo_path' => $path
            ])
            ->log("Driver {$driver->name} menyelesaikan penjemputan order ID {$pickup->order_id}.");

        return redirect()
            ->route('driver.pickup.detail', $pickup->pick_up_id)
            ->with('finished', true);
    }

    return redirect()->route('driver.pickup.detail', $pickup->pick_up_id);
}



}
