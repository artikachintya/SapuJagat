<?php

namespace App\Http\Controllers\Admin;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Facades\Activity as SpatieLog;


class PrintDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $admin = Auth::user();

        // Ambil dari query atau session flash
        $category = $request->category ?? session('category');
        $start_date = $request->start_date ?? session('start_date');
        $end_date = $request->end_date ?? session('end_date');

        $data = collect();

        if ($category === 'order' && $start_date && $end_date) {
            $data = DB::table('order_details as od')
                ->join('orders as o', 'od.order_id', '=', 'o.order_id')
                ->join('pick_ups as p', 'o.order_id', '=', 'p.order_id')
                ->join('approvals as a', 'o.order_id', '=', 'a.order_id')
                ->join('trashes as t', 'od.trash_id', '=', 't.trash_id')
                ->select(
                    't.name as trash_name',
                    't.type',
                    DB::raw('SUM(od.quantity) as total_weight')
                )
                ->where('a.approval_status', '=', '1')
                ->whereBetween(DB::raw('DATE(a.date_time)'), [$start_date, $end_date])
                ->groupBy('t.trash_id', 't.name', 't.type')
                ->orderByDesc('total_weight')
                ->get();
        } elseif ($category === 'withdraw' && $start_date && $end_date) {
            $data = DB::table('withdrawals')
                ->select('bank', DB::raw('SUM(withdrawal_balance) as total_amount'))
                ->whereBetween(DB::raw('DATE(datetime)'), [$start_date, $end_date])
                ->groupBy('bank')
                ->get();
        }

        return view('admin.print-data', compact('admin', 'category', 'data'));
    }


    public function filter(Request $request)
    {
        // Ambil input dari form POST
        $category = $request->category;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        // Redirect ke halaman index dengan flash session (bukan query string)
        return redirect()->route('admin.print-data.index')
            ->with([
                'category' => $category,
                'start_date' => $start_date,
                'end_date' => $end_date
            ]);
    }
    public function generatePdf(Request $request)
    {
        $category = $request->input('category');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // 🔒 Redirect jika diakses langsung tanpa parameter lengkap
        $data = [];

        if ($category === 'order' && $start_date && $end_date) {
            $data = DB::table('order_details as od')
                ->join('orders as o', 'od.order_id', '=', 'o.order_id')
                ->join('pick_ups as p', 'o.order_id', '=', 'p.order_id')
                ->join('approvals as a', 'o.order_id', '=', 'a.order_id')
                ->join('trashes as t', 'od.trash_id', '=', 't.trash_id')
                ->select('t.name as trash_name', 't.type', DB::raw('SUM(od.quantity) as total_weight'))
                ->where('a.approval_status', '=', '1')
                ->whereBetween(DB::raw('DATE(a.date_time)'), [$start_date, $end_date])
                ->groupBy('t.trash_id', 't.name', 't.type')
                ->orderByDesc('total_weight')
                ->get();
        } elseif ($category === 'withdraw' && $start_date && $end_date) {
            $data = DB::table('withdrawals')
                ->select('bank', DB::raw('SUM(withdrawal_balance) as total_amount'))
                ->whereBetween(DB::raw('DATE(datetime)'), [$start_date, $end_date])
                ->groupBy('bank')
                ->get();
        }

        $admin = Auth::user();

        activity('generate_pdf')
            ->causedBy($admin)
            ->withProperties([
                'category' => $category,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ])
            ->log("Admin {$admin->name} generated a PDF report for category: {$category}");

        $pdf = Pdf::loadView('admin.print-pdf', compact('admin', 'category', 'start_date', 'end_date', 'data'));

        return $pdf->stream('laporan.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        if ($id === 'pdf') {
            return redirect()->route('admin.print-data.index')
                ->with('error', 'Akses langsung ke halaman PDF tidak diperbolehkan.');
        }
        // Jika bukan 'pdf', kamu bisa kasih abort atau logic lain
        abort(404);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
