<?php

namespace App\Http\Controllers\Pengguna;
use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelacakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = Order::where('user_id', Auth::id())
            ->whereIn('status', [0, 1, 2, 3])
            ->with(['pickup.user.license']) // cukup 'pickup' saja jika tidak perlu driver di pickup
            ->latest('date_time_request')
            ->first();

        if ($order && $order->status == 0 && $order->pickup) {
            $order->status = 1;
            $order->save();
            // reload ulang agar $order selalu fresh dengan status terbaru
            $order->refresh();
        }

        $approval = 0;
        if ($order) {
            $approval = $order->approval()->first();
        }

        $approval_icon = 'waiting.png'; // default: menunggu konfirmasi
        if ($approval) {
            switch ($approval->approval_status) {
                case 1:
                    $approval_icon = 'successCheck.png'; // berhasil
                    break;
                case 2:
                    $approval_icon = 'rejected.png'; // ditolak
                    break;
                default:
                    $approval_icon = 'waiting.png'; // menunggu
            }
        }

        return view('pengguna.LacakDriver', compact('order', 'approval', 'approval_icon'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $orderId)
    {

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
