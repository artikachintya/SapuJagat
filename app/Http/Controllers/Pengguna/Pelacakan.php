<?php

namespace App\Http\Controllers\Pengguna;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Pelacakan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        // Ambil order aktif yang statusnya belum selesai (0-3)
        $order = Order::where('user_id', $userId)
            ->whereIn('status', [0, 1, 2, 3])
            ->latest('date_time_request')
            ->with(['pickup.user', 'approval'])
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Tidak ada transaksi yang sedang berjalan.');
        }

        return view('pengguna.LacakDriver', compact('order'));
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
