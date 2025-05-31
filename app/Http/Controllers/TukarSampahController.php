<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trash;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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
        $validated = $request->validate([
            'trash' => 'required|array',
        ]);

        $trashItems = $request->input('trash');
        $data = [];
        $totalQty = 0; // Tambahkan variabel untuk menghitung total kuantitas

        foreach ($trashItems as $trashId => $item) {
            $qty = (int) $item['quantity'];

            if ($qty > 10) {
                return back()->withErrors(['quantity' => 'Maksimal berat untuk setiap jenis sampah adalah 10 kg.'])->withInput();
            }

            if ($qty > 0) {
                $trash = Trash::find($trashId);
                $data[] = [
                    'trash_id' => $trashId,
                    'name' => $trash->name,
                    'price' => $trash->price_per_kg,
                    'quantity' => $qty,
                    'total' => $trash->price_per_kg * $qty
                ];
                $totalQty += $qty; // Tambahkan ke total kuantitas
            }
        }

        if (count($data) === 0) {
            return back()->withErrors(['quantity' => 'Silakan pilih dan tentukan jumlah sampah terlebih dahulu sebelum melanjutkan proses penukaran.'])->withInput();
        }

        if ($totalQty < 3) {
            return back()->withErrors(['quantity' => 'Mohon maaf, penukaran tidak dapat diproses. Total berat sampah harus minimal 3 kg.'])->withInput();
        }

        Session::put('data_tukar_sampah', $data);

        return redirect()->route('RingkasanPesanan2');
    }

    public function ringkasan(){
        $data = Session::get('data_tukar_sampah',[]);
        $photoPath = Session::get('photo_path');

        return view('pengguna.RingkasanPesanan2', compact('data','photoPath'));
    }

}


    // public function jemput(Request $request){
    //     $data = Session::get('data_tukar_sampah', []);
    //     // $photoPath = Session::get('photo_path');

    //         if (empty($data)) {
    //             return redirect()->route('TukarSampah1')->with('error', 'Data tidak ditemukan');
    //         }

    //         $request->validate([
    //             'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //         ]);

    //         $photoPath = $request->file('photo')->store('uploads', 'public');

    //         $order = Order::create([
    //             'user_id' => Auth::id(),
    //             'date_time_request' => now(),
    //             'photo' => $photoPath,
    //             'status' => false,
    //         ]);

    //         foreach ($data as $item) {
    //             OrderDetail::create([
    //                 'order_id' => $order->order_id,
    //                 'trash_id' => $item['trash_id'],
    //                 'quantity' => $item['quantity']
    //             ]);
    //         }

    //         Session::forget(['data_tukar_sampah']);

    //         return redirect()->route('TukarSampah1')->with('success', 'Pesanan penjemputan berhasil dikirim!');
    // }

    // public function submit(Request $request)
    // {
    //     // pakai session agar ga langsung keismpen di database
    //     // Yang dari input user → $item['...']
    //     // Yang dari model database → $model->...

    //     $validated = $request->validate([
    //         'trash' => 'required|array',
    //         // 'photo' => 'required|image',
    //     ]);

    //     $trashItems = $request->input('trash');
    //     // $photoPath = $request->file('photo')->store('uploads', 'public');
    //     $validated = $request->validate([
    //         'trash' => 'required|array',
    //     ]);

    //     $data = [];
    //     foreach ($trashItems as $trashId => $item) {
    //         if ((int)$item['quantity'] > 0) {
    //             $trash = Trash::find($trashId);
    //             $data[] = [
    //                 'trash_id' => $trashId,
    //                 'name' => $trash->name,
    //                 'price' => $trash->price_per_kg,
    //                 'quantity' => (int)$item['quantity'],
    //                 'total' => $trash->price_per_kg * (int)$item['quantity']
    //             ];
    //         }
    //     }

    //     Session::put('data_tukar_sampah', $data);
    //     // Session::put('photo_path', $photoPath);

    //     return redirect()->route('RingkasanPesanan2');
    // }
