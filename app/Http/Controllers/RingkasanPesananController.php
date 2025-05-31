<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RingkasanPesananController extends Controller
{
    public function jemput(Request $request)
    {
         // Validasi dasar
        $request->validate([
            'pickup_time' => 'required|string',
            'photo' => 'required|image|max:2048',
        ]);

        // Log untuk debug sementara
        logger('Data request: ', $request->all());

        $data = Session::get('data_tukar_sampah');

        if (!$data || empty($data['items'])) {
            return redirect()->back()->with('error', 'Data pesanan tidak ditemukan.');
        }

        DB::beginTransaction();

        try {
            $order = new Order();
            $order->user_id = 1;
            $order->date_time_request = now();
            $order->pickup_time = $request->input('pickup_time');

            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('public/photos');
                $order->photo = $path;
            } else {
                $order->photo = '';
            }

            $order->status = false;
            $order->save();

            foreach ($data['items'] as $item) {
                OrderDetail::create([
                    'order_id' => $order->order_id,
                    'trash_id' => $item['trash_id'],
                    'quantity' => $item['quantity'],
                ]);
            }

            DB::commit();
            Session::forget('data_tukar_sampah');

            return redirect()->route('TukarSampah1');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan pesanan: ' . $e->getMessage());
        }
    }
}
