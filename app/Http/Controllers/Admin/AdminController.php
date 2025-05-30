<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Withdrawal;
use DB;
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
            'userDiffPercent'
        ));
    }
}
