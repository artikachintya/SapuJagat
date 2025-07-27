<?php

namespace App\Http\Controllers\Pengguna;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLaporanRequest;
use App\Models\Report;

use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $oneMonthAgo = now()->subMonth();

        $laporanList = Report::where('user_id', Auth::id())
            ->where(function ($query) use ($oneMonthAgo) {
                $query->doesntHave('response')
                    ->orWhereHas('response', function ($q) use ($oneMonthAgo) {
                        $q->where('date_time_response', '>=', $oneMonthAgo);
                    });
            })
            ->with('latestResponse') // important: eager load the relationship
            ->orderBy('date_time_report', 'desc')
            ->get();

        return view('pengguna.laporan', compact('laporanList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengguna.laporan-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLaporanRequest $request)
    {
        $validated = $request->validated();

        // Prepare data 
        $data = [
            'user_id' => Auth::check() ? Auth::user()->user_id : 0,
            'date_time_report' => now(),
            'report_message' => $validated['laporan'],
        ];

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('laporan', 'public');
            $data['photo'] = $path;
        }

        // Save to database
        $laporan = Report::create($data);

        activity('create_laporan') // nama log bisa kamu atur sesuai keinginan
            ->causedBy(Auth::user())
            ->performedOn($laporan)
            ->withProperties([
                'report_id' => $laporan->report_id ?? null,
                'report_message' => $laporan->report_message,
            ])
            ->log('User mengirim laporan');


        return redirect()
            ->route('pengguna.laporan.index')
            ->with('success', 'Laporan berhasil dikirim.');
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
