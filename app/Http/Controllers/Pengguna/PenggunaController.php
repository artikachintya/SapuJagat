<?php

namespace App\Http\Controllers\Pengguna;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
public function index()
    {
        // if (auth()->user()->role !== 1) {
        //     abort(403, 'Unauthorized access.');
        // }

        
    
        return view('pengguna.dashboard');
    }
}
