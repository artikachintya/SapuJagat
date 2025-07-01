<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

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
        $validated = $request->validate([
            'report_id' => 'required|exists:reports,report_id',
            'user_id' => 'required|exists:users,user_id',
            'response_message' => 'required|string|max:255',
        ]);

        \App\Models\Response::create([
            'report_id' => $validated['report_id'],
            'user_id' => $validated['user_id'],
            'response_message' => $validated['response_message'],
            'date_time_response' => now(),
        ]);

        return redirect()->route('admin.laporan.index')->with('success', 'Respon berhasil dikirim.');
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
