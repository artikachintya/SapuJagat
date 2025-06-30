<?php

namespace App\Http\Controllers\Pengguna;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Pickup;
use Illuminate\Support\Facades\Auth;

class Histori extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $orderlist = Order::with('details.trash')
        // ->where('user_id', Auth::id())
        // ->orderBy('date_time_request', 'desc')
        // ->get();

        $orderlist = Order::with(['details.trash', 'pickup'])
        ->where('user_id', Auth::id())
        ->orderBy('date_time_request', 'desc')
        ->get();
        // $pickup = Pickup::where('order_id', '')

        return view("pengguna.histori", compact('orderlist'));
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
