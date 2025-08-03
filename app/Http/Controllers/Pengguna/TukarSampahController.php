<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitTukarSampahRequest;
use App\Http\Requests\JemputSampahRequest;
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

use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Log;


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

    public function submit(SubmitTukarSampahRequest $request)
    {
        // Cek alamat user dulu
        $user = Auth::user();

        // Pastikan pengguna sudah melengkapi alamat (khusus untuk role 1)
        if ($user->role === 1) {
            $info = $user->info;

            if (
                empty($info?->address) ||
                empty($info?->province) ||
                empty($info?->city) ||
                empty($info?->postal_code)
            ) {
                // Kalau alamat belum lengkap, redirect balik dengan flag session
                // Jika belum lengkap, kembalikan ke halaman sebelumnya dengan notifikasi
                return redirect()->back()->with('incomplete_address', true);
            }
        }

        // // data sampah dipilih sebagai array
        // $validated = $request->validate([
        //     'trash' => 'required|array',
        // ]);

        $trashItems = $request->input('trash');
        $data = [];
        $totalQty = 0; // Tambahkan variabel untuk menghitung total kuantitas

        // Proses setiap item sampah yang dikirim
        foreach ($trashItems as $trashId => $item) {
            $qty = (int) $item['quantity'];

            // Validasi maksimal berat per jenis sampah lebih dari 10 kg
            if ($qty > 10) {
                return back()->withErrors(['quantity' => __('success.exchange.errors.max_weight')])->withInput();
            }
            // Jika berat > 0, masukkan ke dalam array data
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
        // Jika tidak ada sampah yang dipilih
        if (count($data) === 0) {
            return back()->withErrors(['quantity' => __('success.exchange.errors.no_selection')])->withInput();
        }
        // Validasi minimal total berat = 3 kg
        if ($totalQty < 3) {
            return back()->withErrors(['quantity' =>  __('success.exchange.errors.min_weight')])->withInput();
        }
        // Simpan data ke session untuk diproses di langkah selanjutnya
        Session::put('data_tukar_sampah', $data);
        return redirect()->route('pengguna.RingkasanPesanan2');
    }

    // menampilkan ringkasan pesanan sampah
    public function ringkasan()
    {
        $data = Session::get('data_tukar_sampah', []);
        $photoPath = Session::get('photo_path');

        return view('pengguna.RingkasanPesanan2', compact('data', 'photoPath'));
    }

    // proses penjemputan: validasi, simpan ke database, dan log aktivitas.
    public function jemput(JemputSampahRequest $request)
    {
        $existingOrder = Order::where('user_id', Auth::id())
            ->where('status', false)
            ->whereDoesntHave('approval', function ($q) {
                $q->whereNotNull('approval_status'); // Hanya anggap aktif jika belum ada approval
            })
            ->latest('date_time_request')
            ->first();

        // Jika masih ada pesanan aktif, redirect ke pelacakan + notifikasi
        if ($existingOrder) {
            return redirect()->route('pengguna.pelacakan.index')
                ->with('error', __('success.exchange.exist'));
        }

        // // Validasi dasar
        // $request->validate([
        //     'pickup_time' => 'required|string',
        //     'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        // ]);

        // Log untuk debug sementara
        logger('Data request: ', $request->all());

        $data = Session::get('data_tukar_sampah');

        if (empty($data)) {
            return redirect()->back()->with('error', __('success.exchange.errors.data_not_found'));
        }

        $photoPath = $request->file('photo')->store('uploads', 'public');

        $order = Order::create([
            'user_id' => Auth::id(),
            'date_time_request' => now(),
            'photo' => $photoPath,
            'pickup_time' => $request->pickup_time,
            'status' => false,
        ]);

        // Simpan detail item pesanan
        foreach ($data as $item) {
            OrderDetail::create([
                'order_id' => $order->order_id,
                'trash_id' => $item['trash_id'],
                'quantity' => $item['quantity']
            ]);
        }

        // Hapus data dari session setelah disimpan
        Session::forget(['data_tukar_sampah']);

        // Log aktivitas menggunakan Spatie Activity Log
        activity('create_order')
            ->causedBy(Auth::user())
            ->performedOn($order)
            ->withProperties([
                'order_id' => $order->order_id,
                'pickup_time' => $order->pickup_time,
                'total_items' => count($data),
            ])
            ->log('User melakukan pemesanan sampah');

        // Redirect ke halaman pelacakan dengan notifikasi sukses
        return redirect()->route('pengguna.pelacakan.index')->with('success', __('success.exchange.success.order_created'));
    }
}


