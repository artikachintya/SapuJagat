<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Pickup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoriDriver extends Controller
{

    public function index()
    {
        $pickuplist = Pickup::with('order')->where('user_id', Auth::id())->get();

        return view("driver.histori", compact('pickuplist'));
    }

    
}
