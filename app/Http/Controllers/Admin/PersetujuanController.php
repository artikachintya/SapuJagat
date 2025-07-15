<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Approval;
use App\Models\Order;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class PersetujuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['pickUp', 'approval'])           // eager‑load relations
               ->whereHas('pickUp')                     // MUST have a pick‑up
               ->where(function ($q) {                  // ( approval ≠ 0/1 ) OR (no approval row)
                   $q->whereDoesntHave('approval')      // <‑‑ without approval
                     ->orWhereHas('approval', function ($q2) {
                         $q2->whereNotIn('approval_status', [0, 1]);  // <‑‑ approval not 0/1
                     });
               })
               ->get();
        
        $transaksidisetujui = Order::whereHas('approval', function ($query) {
            $query->where('approval_status', 1);
        })->count();

        $transaksiditolak = Order::whereHas('approval', function ($query) {
            $query->where('approval_status', 0);
        })->count();

        $transaksihariini = Order::whereHas('pickUp')->whereDate('date_time_request', Carbon::today())->count();

        return view('admin.persetujuan', compact('orders','transaksidisetujui','transaksiditolak','transaksihariini'));
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
        $data = $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'user_id'  => 'required|exists:users,user_id',
            'notes' => 'required|string',
            'approval_status' => 'required|in:0,1,2',
        ]);

        Approval::updateOrCreate(
        ['order_id' => $data['order_id']],   // kolom pencarian
            [
                'user_id'         => $data['user_id'],
                'date_time'       => now(),
                'approval_status' => $data['approval_status'],
                'notes'           => $data['notes'],
            ]
        );

        // ─── Tambah balance hanya jika status disetujui (1) ───
        if ((int) $data['approval_status'] === 1) {
            $orderId = $data['order_id'];
            $userId = $data['user_id'];

            // Ambil semua detail pesanan untuk hitung total harga
            $orderDetails = DB::table('order_details')
                ->where('order_id', $orderId)
                ->get();

            $totalBalance = 0;

            foreach ($orderDetails as $detail) {
                $trash = DB::table('trashes')
                    ->where('trash_id', $detail->trash_id)
                    ->first();

                if ($trash) {
                    $totalBalance += $trash->price_per_kg * $detail->quantity;
                }
            }

            // Simpan atau update ke users_info
            DB::table('users_info')->updateOrInsert(
                ['user_id' => $userId],
                [
                    'address'     => '-',
                    'province'    => '-',
                    'city'        => '-',
                    'postal_code' => '-',
                    'balance'     => DB::raw("COALESCE(balance, 0) + $totalBalance")
                ]
            );
        }

        /** ───── Tentukan teks status ───── */
        $statusLabel = match ((int) $data['approval_status']) {
            0       => 'Ditolak',
            1       => 'Disetujui',
            2       => 'Menunggu',
            default => 'Diproses',
        };
        /** ───── Buat pesan flash ───── */
        $message = "Order #{$data['order_id']} telah direspons: {$statusLabel}.";

        return back()->with('success', $message);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
