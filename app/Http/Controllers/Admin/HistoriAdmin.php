<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class HistoriAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['user', 'details.trash', 'pickup', 'approval']) // eager load relations
            ->orderBy('date_time_request', 'desc') // newest orders first
            ->get();
        // dd($orders->pluck('date_time_request'));
        return view('admin.histori', compact('orders'));
    }
}
