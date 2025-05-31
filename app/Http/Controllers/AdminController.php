<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
public function index()
    {
        // if (auth()->user()->role !== 2) {
        //     abort(403, 'Unauthorized access.');
        // }

        return view('admin.dashboard');
    }
}
