<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trash;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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
         // 🔒 Cek alamat user dulu
            $user = Auth::user();

            if ($user->role === 1) {
                $info = $user->info;

                if (
                    empty($info?->address) ||
                    empty($info?->province) ||
                    empty($info?->city) ||
                    empty($info?->postal_code)
                ) {
                    // Kalau alamat belum lengkap, redirect balik dengan flag session
                    return redirect()->back()->with('incomplete_address', true);
                }
            }

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
        return redirect()->route('pengguna.RingkasanPesanan2');
    }

    public function ringkasan(){
        $data = Session::get('data_tukar_sampah',[]);
        $photoPath = Session::get('photo_path');

        return view('pengguna.RingkasanPesanan2', compact('data','photoPath'));
    }

    public function jemput(Request $request)
    {
         // Validasi dasar
        $request->validate([
            'pickup_time' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Log untuk debug sementara
        logger('Data request: ', $request->all());

        $data = Session::get('data_tukar_sampah');

        if (empty($data)) {
            return redirect()->back()->with('error', 'Data pesanan tidak ditemukan.');
        }

        // $request->validate([
        //     'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        // ]);

        $photoPath = $request->file('photo')->store('uploads', 'public');

        $order = Order::create([
            'user_id' => Auth::id(),
            'date_time_request' => now(),
            'photo' => $photoPath,
            'pickup_time'=>$request->pickup_time,
            'status' => false,
        ]);

        foreach ($data as $item) {
            OrderDetail::create([
                'order_id' => $order->order_id,
                'trash_id' => $item['trash_id'],
                'quantity' => $item['quantity']
            ]);
        }

        Session::forget(['data_tukar_sampah']);

        return redirect()->route('pengguna.pelacakan.index')->with('success', 'Pesanan penjemputan berhasil dikirim!');
    }

}
