<?php

namespace App\Http\Controllers\Pengguna;
use App\Http\Controllers\Admin\PenugasanController;
use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Order;
use App\Models\Chat;
use App\Models\Penugasan;
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
            ->whereIn('status', [false, true]) // ambil semua status
            ->with(['pickup.user.license', 'approval'])
            ->latest('date_time_request')
            ->first();

        // if ($order) {
        //     $penugasan = Penugasan::where('order_id', $order->order_id)->first();

        //     // Simpan status: apakah sudah dapat driver?
        //     $order->sudah_dapat_driver = $penugasan ? true : false;
        // }

        $approval = $order ? $order->approval()->first() : 0;

        $approval_icon = 'waiting.png';

        if ($approval && $approval->approval_status !== null) {
            switch ($approval->approval_status) {
                case 0:
                    $approval_icon = 'rejected.png';

                    break;
                case 1:
                    $approval_icon = 'successCheck.png';
                    break;
                case 2:
                    $approval_icon = 'waiting.png';
                    break;
                default:
                    $approval_icon = 'waiting.png';
            }
        }

        // Penugasan hanya berlaku jika order status masih proses
        $sudah_dapat_driver = false;
        if ($order && $order->status == false) {
            $penugasan = Penugasan::where('order_id', $order->order_id)->first();
            $sudah_dapat_driver = $penugasan ? true : false;
        } elseif ($order && $order->status == true) {
            $sudah_dapat_driver = true; // karena sudah selesai → tampilkan hasil akhir
        }

        // inject ke objek order biar bisa dipakai di Blade
        if ($order) {
            $order->sudah_dapat_driver = $sudah_dapat_driver;
        }

        $chat = null;
        if ($order && $order->pickup && $order->pickup->user_id) {
            $userId = Auth::id();
            $driverId = $order->pickup->user_id;

            $chat = Chat::firstOrCreate(
                ['user_id' => $userId, 'driver_id' => $driverId],
                ['date_time_created' => now()]
            );
        }

        $penugasan = null;
        $driver_photo = null; // default

        if ($order) {
            $penugasan = Penugasan::where('order_id', $order->order_id)
                ->with('user') // pastikan eager load relasi user (driver)
                ->first();

            if ($penugasan && $penugasan->user && $penugasan->user->profile_pic) {
                $driver_photo = asset('storage/' . $penugasan->user->profile_pic);
            }
        }

        return view('pengguna.LacakDriver', compact('order', 'approval', 'approval_icon', 'chat', 'driver_photo'));
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
