<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreReportResponseRequest;
use Illuminate\Http\Request;
use App\Models\Report;

class ResponLaporan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Menampilkan daftar laporan pengguna beserta responnya
    // Fungsi ini akan mengambil semua data laporan dan me-load relasi user pelapor dan admin yang memberi respon.
    // Data diurutkan berdasarkan waktu laporan secara menurun (terbaru di atas).
    public function index()
    {
        $reports = Report::with(['user', 'response.user']) // eager load user pelapor dan admin responder
            ->orderBy('date_time_report', 'desc')
            // ->paginate(10); // pagination biar lebih ringan
            ->get();
        // dd($reports);
        return view('admin.response-admin', compact('reports'));
    }

    // Menyimpan respon admin terhadap laporan pengguna.
    // Menggunakan Form Request `StoreReportResponseRequest` untuk validasi otomatis.
    public function store(StoreReportResponseRequest $request)
    {
        $validated = $request->validated();

        \App\Models\Response::create([
            'report_id' => $validated['report_id'],
            'user_id' => $validated['user_id'],
            'response_message' => $validated['response_message'],
            'date_time_response' => now(),
        ]);

        return redirect()->route('admin.laporan.index')->with('success', __('success.respon'));
    }

}
