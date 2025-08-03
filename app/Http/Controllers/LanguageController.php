<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguangeInvokeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LanguangeInvokeRequest $request)
    {
        Session::put('lang', $request->lang);
        return redirect()->back();
    }
}
