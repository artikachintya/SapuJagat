<?php

namespace App\Http\Controllers\Pengguna;
use App\Http\Controllers\Controller;

use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index()
    {
        // if (auth()->user()->role !== 1) {
        //     abort(403, 'Unauthorized access.');
        // }

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors('Silakan login terlebih dahulu.');
        }

        //Total balance
        $totalBalance = $user->info->balance ?? 0;

        //Withdrawals this month
        // $monthlyWithdrawals = $user->withdrawals()
        //     ->whereMonth('datetime', now()->month)
        //     ->whereYear('datetime', now()->year)
        //     ->sum('withdrawal_balance');
        $monthlyWithdrawals = $user
            ? $user->withdrawals()
                ->whereMonth('datetime', now()->month)
                ->whereYear('datetime', now()->year)
                ->sum('withdrawal_balance')
            : 0;

        // Approved orders this month
        $approvedOrdersCount = $user ? $user->orders()
            ->whereHas('approval', function ($query) {
                $query->where('approval_status', 1)
                    ->whereMonth('date_time', now()->month)
                    ->whereYear('date_time', now()->year);
            })
            ->count()
            : 0;

        // Unapproved orders this month
        $unapprovedOrdersCount = $user ? $user->orders()
            ->whereDoesntHave('approval')
            ->whereMonth('date_time_request', now()->month)
            ->whereYear('date_time_request', now()->year)
            ->count()
            : 0;

        //Most ordered trash type (by quantity)
        $topTrash = DB::table('orders')
            ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
            ->join('trashes', 'order_details.trash_id', '=', 'trashes.trash_id')
            ->where('orders.user_id', $user->user_id)
            ->select('trashes.name', DB::raw('SUM(order_details.quantity) as total_qty'))
            ->groupBy('trashes.name')
            ->orderByDesc('total_qty')
            ->first();

        $topTrashName = $topTrash->name ?? '-';

        $start = \Carbon\Carbon::now()->startOfMonth()->translatedFormat('d M, Y');
        $end = \Carbon\Carbon::now()->endOfMonth()->translatedFormat('d M, Y');

        // Ambil tanggal awal dan akhir bulan sekarang
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d 00:00:00');
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d 23:59:59');

        // Buat array tanggal dalam bulan ini
        $daysInMonth = Carbon::now()->daysInMonth;
        $dates = collect(range(1, $daysInMonth))->map(function ($day) {
            return Carbon::now()->format('Y-m') . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
        })->toArray();

        // Ambil semua nama jenis sampah
        $trashNames = DB::table('trashes')->pluck('name')->toArray();
        $trashColors = [
            'Sisa Makanan' => 'rgba(139, 195, 74, 1)',     // Hijau
            'Kulit Buah' => 'rgba(255, 152, 0, 1)',      // Oranye
            'Daun Kering' => 'rgba(205, 220, 57, 1)',     // Lime
            'Kotoran Hewan' => 'rgba(121, 85, 72, 1)',      // Coklat
            'Cangkang Telur' => 'rgba(255, 235, 59, 1)',     // Kuning cerah
            'Botol Plastik' => 'rgba(33, 150, 243, 1)',     // Biru terang
            'Kaleng' => 'rgba(96, 125, 139, 1)',     // Abu kebiruan
            'Kardus' => 'rgba(244, 67, 54, 1)',      // Merah
            'Kaca Pecah' => 'rgba(0, 188, 212, 1)',      // Cyan
            'Styrofoam' => 'rgba(156, 39, 176, 1)',     // Ungu
        ];

        // Ambil hasil dari DB (per tanggal)
        $results = DB::table('orders')
            ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
            ->join('trashes', 'order_details.trash_id', '=', 'trashes.trash_id')
            ->selectRaw("trashes.name, DATE(orders.date_time_request) as date, SUM(order_details.quantity) as total")
            ->where('orders.user_id', $user->user_id)
            ->whereBetween('orders.date_time_request', [$startOfMonth, $endOfMonth])
            ->groupBy('trashes.name', DB::raw("DATE(orders.date_time_request)"))
            ->get();

        // Siapkan struktur data untuk chart
        $chartSeries = [];

        foreach ($trashNames as $trashName) {
            $dailyTotals = [];

            foreach ($dates as $date) {
                $found = $results->first(function ($item) use ($trashName, $date) {
                    return $item->name === $trashName && $item->date === $date;
                });

                $dailyTotals[] = $found ? $found->total : 0;
            }

            $chartSeries[] = [
                'label' => $trashName,
                'data' => $dailyTotals,
                'borderColor' => $trashColors[$trashName] ?? 'rgba(150, 150, 150, 1)',
                'backgroundColor' => $trashColors[$trashName] ?? 'rgba(150, 150, 150, 1)',
                'tension' => 0.3,
                'fill' => false,
            ];
        }

        $labels = $dates; // Label X Axis berupa tanggal-tanggal dalam bulan ini

        // dd($monthlyData);
        // dd($chartSeries, $labels);

        return view('pengguna.dashboard', compact(
            'totalBalance',
            'monthlyWithdrawals',
            'topTrashName',
            'approvedOrdersCount',
            'unapprovedOrdersCount',
            'chartSeries',
            'labels',
            'trashColors',
            'start',
            'end'
        ));
    }
}
