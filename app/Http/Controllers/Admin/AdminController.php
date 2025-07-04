<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Withdrawal;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // if (auth()->user()->role !== 2) {
        //     abort(403, 'Unauthorized access.');
        // }

        $lastMonth = now()->subMonth();

        // Returning 3 Box Data
        //Transaksi Harian
        $todayTransactions = Order::whereDate('date_time_request', now()->toDateString())->count();
        // Jumlah uang keluar
        $totalMoneyOut = DB::table('orders')
            ->join('approvals', 'orders.order_id', '=', 'approvals.order_id')
            ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
            ->join('trashes', 'order_details.trash_id', '=', 'trashes.trash_id')
            ->where('approvals.approval_status', 1)
            ->whereDate('approvals.date_time', now()->toDateString())
            ->selectRaw('SUM(order_details.quantity * trashes.price_per_kg) as total_money_out')
            ->value('total_money_out');
        // transaksi diproses
        $processedTransactions = Order::whereDoesntHave('approval')->count();

        // Statistik Bulanan
        // Total user aktif bulan ini
        $ordersThisMonth = Order::whereMonth('date_time_request', now()->month)
            ->whereYear('date_time_request', now()->year)
            ->pluck('user_id');

        $withdrawalsThisMonth = Withdrawal::whereMonth('datetime', now()->month)
            ->whereYear('datetime', now()->year)
            ->pluck('user_id');

        $activeUserCount = $ordersThisMonth->merge($withdrawalsThisMonth)->unique()->count();

        // Tipe Sampah Terbanyak
        $mostOrderedTrash = DB::table('order_details')
            ->join('trashes', 'order_details.trash_id', '=', 'trashes.trash_id')
            ->select('trashes.name', DB::raw('SUM(order_details.quantity) as total_qty'))
            ->groupBy('order_details.trash_id', 'trashes.name')
            ->orderByDesc('total_qty')
            ->first();

        // Tipe Sampah terbanyak
        $totalTransactions = Order::whereMonth('date_time_request', now()->month)
            ->whereYear('date_time_request', now()->year)
            ->count();

        //Bottom info
        //total trash in
        $totalTrashKg = DB::table('orders')
            ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
            ->whereMonth('orders.date_time_request', now()->month)
            ->whereYear('orders.date_time_request', now()->year)
            ->sum('order_details.quantity');

        //Total money out
        $totalMoneyOutMonth = DB::table('orders')
            ->join('approvals', 'orders.order_id', '=', 'approvals.order_id')
            ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
            ->join('trashes', 'order_details.trash_id', '=', 'trashes.trash_id')
            ->where('approvals.approval_status', 1)
            ->whereMonth('approvals.date_time', now()->month)
            ->whereYear('approvals.date_time', now()->year)
            ->selectRaw('SUM(order_details.quantity * trashes.price_per_kg) as total_money_out')
            ->value('total_money_out');

        $activeDrivers = DB::table('pick_ups')
            ->join('users', 'pick_ups.user_id', '=', 'users.user_id')
            ->whereMonth('pick_ups.pick_up_date', now()->month)
            ->whereYear('pick_ups.pick_up_date', now()->year)
            ->select('pick_ups.user_id')
            ->distinct()
            ->count('pick_ups.user_id');

        // Little info
        $lastMonthTrashKg = DB::table('orders')
            ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
            ->whereMonth('orders.date_time_request', $lastMonth->month)
            ->whereYear('orders.date_time_request', $lastMonth->year)
            ->sum('order_details.quantity');

        $trashKgDiffPercent = $lastMonthTrashKg == 0 ? null :
            (($totalTrashKg - $lastMonthTrashKg) / $lastMonthTrashKg) * 100;

        $lastMonthMoneyOut = DB::table('orders')
            ->join('approvals', 'orders.order_id', '=', 'approvals.order_id')
            ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
            ->join('trashes', 'order_details.trash_id', '=', 'trashes.trash_id')
            ->where('approvals.approval_status', 1)
            ->whereMonth('approvals.date_time', $lastMonth->month)
            ->whereYear('approvals.date_time', $lastMonth->year)
            ->selectRaw('SUM(order_details.quantity * trashes.price_per_kg) as total_money_out')
            ->value('total_money_out');

        $moneyOutDiffPercent = $lastMonthMoneyOut == 0 ? null :
            (($totalMoneyOutMonth - $lastMonthMoneyOut) / $lastMonthMoneyOut) * 100;

        $lastMonthActiveDrivers = DB::table('pick_ups')
            ->whereMonth('pick_ups.pick_up_date', $lastMonth->month)
            ->whereYear('pick_ups.pick_up_date', $lastMonth->year)
            ->distinct()
            ->count('pick_ups.user_id');

        $driverDiffPercent = $lastMonthActiveDrivers == 0 ? null :
            (($activeDrivers - $lastMonthActiveDrivers) / $lastMonthActiveDrivers) * 100;

        $latestOrders = Order::latest('date_time_request')
            ->with(['user', 'details', 'pickup', 'approval']) // adjust relation names if different
            ->take(5)
            ->get();

        $pendingApprovals = Order::with(['approval'])
            ->WhereDoesntHave('approval')
            ->oldest('date_time_request')
            ->take(5)
            ->get();

        $lastMonthDate = now()->subMonth();
        $lastYear = $lastMonthDate->year;

        $lastMonthUserCount = DB::table('orders')
            ->whereMonth('date_time_request', $lastMonth)
            ->whereYear('date_time_request', $lastYear)
            ->distinct()
            ->count('user_id');
        if ($lastMonthUserCount > 0) {
            $userDiffPercent = (($activeUserCount - $lastMonthUserCount) / $lastMonthUserCount) * 100;
        } else {
            $userDiffPercent = null; // Avoid divide by zero
        }

        $start = \Carbon\Carbon::now()->startOfMonth()->translatedFormat('d M, Y');
        $end = \Carbon\Carbon::now()->endOfMonth()->translatedFormat('d M, Y');

        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d 00:00:00');
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d 23:59:59');

        $daysInMonth = Carbon::now()->daysInMonth;
        $dates = collect(range(1, $daysInMonth))->map(function ($day) {
            return Carbon::now()->format('Y-m') . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
        })->toArray();

        $trashNames = DB::table('trashes')->pluck('name')->toArray();
        $trashColors = [
            'Sisa Makanan' => 'rgba(139, 195, 74, 1)',
            'Kulit Buah' => 'rgba(255, 152, 0, 1)',
            'Daun Kering' => 'rgba(205, 220, 57, 1)',
            'Kotoran Hewan' => 'rgba(121, 85, 72, 1)',
            'Cangkang Telur' => 'rgba(255, 235, 59, 1)',
            'Botol Plastik' => 'rgba(33, 150, 243, 1)',
            'Kaleng' => 'rgba(96, 125, 139, 1)',
            'Kardus' => 'rgba(244, 67, 54, 1)',
            'Kaca Pecah' => 'rgba(0, 188, 212, 1)',
            'Styrofoam' => 'rgba(156, 39, 176, 1)',
        ];

        $results = DB::table('orders')
            ->join('approvals', 'orders.order_id', '=', 'approvals.order_id')
            ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
            ->join('trashes', 'order_details.trash_id', '=', 'trashes.trash_id')
            ->selectRaw("trashes.name, DATE(orders.date_time_request) as date, SUM(order_details.quantity) as total")
            ->where('approvals.approval_status', 1)
            ->whereBetween('orders.date_time_request', [$startOfMonth, $endOfMonth])
            ->groupBy('trashes.name', DB::raw("DATE(orders.date_time_request)"))
            ->get();

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
                'borderColor' => $trashColors[$trashName] ?? 'rgba(150,150,150,1)',
                'backgroundColor' => $trashColors[$trashName] ?? 'rgba(150,150,150,1)',
                'tension' => 0.3,
                'fill' => false,
            ];
        }

        return view('admin.dashboard', compact(
            'todayTransactions',
            'totalMoneyOut',
            'processedTransactions',
            'activeUserCount',
            'mostOrderedTrash',
            'totalTransactions',
            'totalMoneyOutMonth',
            'totalTrashKg',
            'activeDrivers',
            'latestOrders',
            'pendingApprovals',
            'trashKgDiffPercent',
            'moneyOutDiffPercent',
            'driverDiffPercent',
            'userDiffPercent',
            'chartSeries',
            'dates',
            'trashColors',
            'start',
            'end'
        ));
    }
}
