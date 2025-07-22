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
    public function index()
    {
        $reports = Report::with(['user', 'response.user']) // eager load user pelapor dan admin responder
            ->orderBy('date_time_report', 'desc')
            // ->paginate(10); // pagination biar lebih ringan
            ->get();
        // dd($reports);
        return view('admin.response-admin', compact('reports'));
    }

    public function store(StoreReportResponseRequest $request)
    {
        $validated = $request->validated();

        \App\Models\Response::create([
            'report_id' => $validated['report_id'],
            'user_id' => $validated['user_id'],
            'response_message' => $validated['response_message'],
            'date_time_response' => now(),
        ]);

        return redirect()->route('admin.laporan.index')->with('success', 'Respon berhasil dikirim.');
    }

}
