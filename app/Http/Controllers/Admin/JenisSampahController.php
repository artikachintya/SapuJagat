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
        | 2. CREATE NEW RECORD
        * ---------------------------------------------------------*/
        $trash = new Trash;
        $trash->name   = $requestRaw->name;
        $trash->type  = $requestRaw->type;          // adjust if your column name differs
        $trash->price_per_kg  = $requestRaw->price_per_kg;
        $trash->max_weight    = $requestRaw->max_weight;    // nullable OK

        /* ----------------------------------------------------------
        | 3. HANDLE FILE UPLOAD (optional)
        * ---------------------------------------------------------*/
        if ($requestRaw->hasFile('photos')) {
            $file      = $requestRaw->file('photos');
            $filename  = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img'), $filename);

            $trash->photos = $filename;
        }

        /* ----------------------------------------------------------
        | 4. SAVE & REDIRECT
        * ---------------------------------------------------------*/
        $trash->save();

        return redirect()->back()->with('success', __('success.trash.store_success'));
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
    public function update(StoreJenisSampahRequest $request, $id)
    {

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
        return redirect()->back()->with('success', __('success.trash.update_success'));
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

        return back()->with('success', __('success.trash.delete_success'));
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
        return redirect()->route('admin.jenis-sampah.index')->with('success', __('success.trash.restore_success'));
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

        return back()->with('success', __('success.trash.force_delete_success'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $csv = array_map('str_getcsv', file($file));
        $header = array_map('trim', $csv[0]); // baris pertama = header
        unset($csv[0]); // buang header dari data

        $inserted = 0;
        $skipped = 0;

        foreach ($csv as $row) {
            $row = array_map('trim', $row);
            $data = array_combine($header, $row);

            // Cek apakah nama sudah ada
            if (Trash::where('name', $data['name'])->exists()) {
                $skipped++;
                $duplicatesList[] = $data['name'];
                continue;
            }

            Trash::create([
                'name'            => $data['name'],
                'type'            => $data['type'],
                'price_per_kg'    => $data['price_per_kg'],
                'max_weight'      => $data['max_weight'],
                'photos'          => $data['photos'],
            ]);
            $inserted++;
        }
        // dd($inserted, $duplicatesList, $skipped);
        return redirect()->back()->with('success', __('success.trash.import_success',  ['inserted' => $inserted,'skipped' => $skipped]));
    }

}
