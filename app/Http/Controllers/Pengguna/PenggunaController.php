<?php

namespace App\Http\Controllers\Pengguna;
use App\Http\Controllers\Controller;

use DB;
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

        //Total balance
        $totalBalance = $user->info->balance ?? 0;

        //Withdrawals this month
        $monthlyWithdrawals = $user->withdrawals()
            ->whereMonth('datetime', now()->month)
            ->whereYear('datetime', now()->year)
            ->sum('withdrawal_balance');

        // Approved orders this month
        $approvedOrdersCount = $user->orders()
            ->whereHas('approval', function ($query) {
                $query->where('approval_status', 1)
                    ->whereMonth('date_time', now()->month)
                    ->whereYear('date_time', now()->year);
            })
            ->count();

        // Unapproved orders this month
        $unapprovedOrdersCount = $user->orders()
            ->whereDoesntHave('approval')
            ->whereMonth('date_time_request', now()->month)
            ->whereYear('date_time_request', now()->year)
            ->count();

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
    
        return view('pengguna.dashboard', compact(
            'totalBalance',
            'monthlyWithdrawals',
            'topTrashName',
            'approvedOrdersCount',
            'unapprovedOrdersCount'
        ));
    }
}
