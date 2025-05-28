<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trash;

class TukarSampahController extends Controller
{
    public function index()
    {
        // Ambil semua sampah berdasarkan jenis
        $sampahOrganik = Trash::where('type', 'Organik')->get();
        $sampahAnorganik = Trash::where('type', 'Anorganik')->get();

        // Kirim ke view
        return view('pengguna.TukarSampah1', compact('sampahOrganik', 'sampahAnorganik'));
    }

    public function submit(Request $request)
    {
        // Sementara hanya dump untuk cek
        dd($request->all());
    }
}
