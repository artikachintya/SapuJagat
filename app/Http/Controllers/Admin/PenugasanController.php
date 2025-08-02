<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\StorePenugasanRequest;
use App\Models\Order;
use App\Models\Penugasan;
use App\Models\Pickup;
use App\Models\Trash;
use App\Models\User;
use App\Models\Withdrawal;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Http\Request;

class PenugasanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penugasans = Order::with([
            'user:user_id,name',
            'penugasan:penugasan_id,order_id,status,user_id'
        ])
        // ── keep orders whose penugasan is status 0 OR no penugasan at all
        ->where(fn ($q) =>
            $q->whereRelation('penugasan', 'status', 0)
            ->orDoesntHave('penugasan')
        )
        // ── drop orders that have an approval row with status 0 or 1
        ->whereDoesntHave('approval', fn ($q) =>
            $q->whereIn('approval_status', [0, 1])
        )
        ->get();

        $drivers=User::where('role',3)->get();

        //  Return to Blade (or JSON if you prefer an API)
        return view('admin.penugasan', compact('penugasans','drivers'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenugasanRequest $request)
    {
        // 1. Validasi input
        $data = $request->validated();

        // 2. Simpan ke DB
        $penugasan = Penugasan::create([
            'order_id'   => $data['order_id'],
            'user_id'    => $data['user_id'],
            'status'     => 0,
            'created_at' => Carbon::now(),     // kolom created_at
        ]);

          // 3. Simpan juga ke tabel pick_ups
        Pickup::create([
            'order_id' => $data['order_id'],
            'user_id'  => $data['user_id'],
            'penugasan_id'  => $penugasan->penugasan_id,
            // tambahkan kolom lain yang dibutuhkan jika ada (misalnya status awal)
        ]);

        // 3. Redirect back + flash
        return redirect()
            ->back()
            ->with('success', "Penugasan #{$penugasan->penugasan_id} berhasil dibuat.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penugasan = Penugasan::findOrFail($id);

         // Soft delete: pickup juga ikut dihapus
        Pickup::where('penugasan_id', $penugasan->penugasan_id)->delete();

        // Soft delete: tidak menghapus permanen
        $penugasan->delete();

        return back()->with('success', 'Penugasan berhasil dihapus!');
    }

    public function archive(){
        $penugasans = Penugasan::onlyTrashed()->with(['order','user'])->get();
        return view('admin.penugasan-arsip',compact('penugasans'));
    }

    public function restore($id){
        $penugasan = Penugasan::withTrashed()->findOrFail($id);
        $penugasan->restore();
        Pickup::withTrashed()
        ->where('penugasan_id', $penugasan->penugasan_id)
        ->restore();
        return redirect()->route('admin.penugasan.archive')->with('success', 'Penugasan berhasil dipulihkan.');
    }


    public function forceDelete($id){
        $penugasan = Penugasan::withTrashed()->findOrFail($id);
        Pickup::where('penugasan_id', $penugasan->penugasan_id)->delete(); // optional
        $penugasan->forceDelete();
        return redirect()->route('admin.penugasan.archive')->with('success', 'Penugasan dihapus permanen.');
    }
}
