<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreJenisSampahRequest;
use App\Models\Order;
use App\Models\Trash;
use App\Models\Withdrawal;
use DB;
use File;
use Illuminate\Http\Request;

class JenisSampahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $trashes=Trash::get();

    //     return view('admin.jenis', compact('trashes'));
    // }
    // soft delete
    public function index()
    {
        $trashes = Trash::all(); // soft delete otomatis tidak tampil
        return view('admin.jenis', compact('trashes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJenisSampahRequest $requestRaw)
    {
        /* ----------------------------------------------------------
        | 1. VALIDATE INPUT
        * ---------------------------------------------------------*/
        $request = $requestRaw->validated();

        /* ----------------------------------------------------------
        | 2. CREATE NEW RECORD
        * ---------------------------------------------------------*/
        $trash = new Trash;
        $trash->name   = $request->name;
        $trash->type  = $request->type;          // adjust if your column name differs
        $trash->price_per_kg  = $request->price_per_kg;
        $trash->max_weight    = $request->max_weight;    // nullable OK

        /* ----------------------------------------------------------
        | 3. HANDLE FILE UPLOAD (optional)
        * ---------------------------------------------------------*/
        if ($request->hasFile('photos')) {
            $file      = $request->file('photos');
            $filename  = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img'), $filename);

            $trash->photos = $filename;
        }

        /* ----------------------------------------------------------
        | 4. SAVE & REDIRECT
        * ---------------------------------------------------------*/
        $trash->save();

        return redirect()->back()->with('success', 'Jenis sampah berhasil ditambahkan.');
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
    public function update(Request $request, $id)
    {
        // 1. Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'photos' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'type' => 'required|string|max:255',
            'price_per_kg' => 'required|numeric',
            'max_weight' => 'nullable|numeric',
        ]);

        // 2. Ambil data berdasarkan ID
        $trash = Trash::findOrFail($id);

        // 3. Update data
        $trash->name = $request->name;
        $trash->type = $request->type;
        $trash->price_per_kg = $request->price_per_kg;
        $trash->max_weight = $request->max_weight;

        // 4. Cek apakah ada file foto diupload
        if ($request->hasFile('photos')) {
            // Hapus foto lama jika ada
            if ($trash->photos && file_exists(public_path('assets/img/' . $trash->photos))) {
                unlink(public_path('assets/img/' . $trash->photos));
            }

            // Simpan foto baru
            $file = $request->file('photos');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img'), $filename);

            $trash->photos = $filename;
        }

        // 5. Simpan perubahan
        $trash->save();

        // 6. Redirect (or return JSON if needed)
        return redirect()->back()->with('success', 'Jenis sampah berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trash=Trash::findOrFail($id);
        // if ($trash->photos &&
        //     File::exists(public_path("assets/img/{$trash->photos}"))) {
        //     File::delete(public_path("assets/img/{$trash->photos}"));
        // }


        $trash->delete();   // soft‑delete if model uses SoftDeletes, otherwise hard

        return back()->with('success', 'Jenis sampah berhasil dihapus.');
    }

    // Tampilkan yang sudah dihapus
    public function archive()
    {
        $trashes = Trash::onlyTrashed()->get();
        return view('admin.trash-archive', compact('trashes'));
    }

    // Pulihkan data
    public function restore($id)
    {
        $trash = Trash::onlyTrashed()->findOrFail($id);
        $trash->restore();
        return redirect()->route('admin.jenis-sampah.index')->with('success', 'Data berhasil dipulihkan.');
    }


    // forcedelete untuk permanent
    public function forceDelete($id)
    {
        $trash = Trash::onlyTrashed()->findOrFail($id);

        // Hapus file foto jika ada
        if ($trash->photos && File::exists(public_path("assets/img/{$trash->photos}"))) {
            File::delete(public_path("assets/img/{$trash->photos}"));
        }

        $trash->forceDelete();

        return back()->with('success', 'Data dihapus permanen.');
    }

}
