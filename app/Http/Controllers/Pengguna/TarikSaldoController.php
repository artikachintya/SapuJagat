<?php


namespace App\Http\Controllers\Pengguna;
use App\Http\Controllers\Controller;

use App\Models\UserInfo;
use App\Models\Withdrawal;
use Auth;
use Illuminate\Http\Request;

class TarikSaldoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $totalBalance = $user->info->balance ?? 0;

         $monthlyWithdrawals = $user
            ? $user->withdrawals()
                    ->whereMonth('datetime', now()->month)
                    ->whereYear('datetime', now()->year)
                    ->sum('withdrawal_balance')
            :0;

        return view('pengguna.TarikSaldo',compact('totalBalance','monthlyWithdrawals'));
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
        $request->validate([
            'amount' => 'required|numeric|min:50000',
            'bank' => 'required|string|max:50',
            'number' => 'required|string|max:30',
        ], [
            'amount.required' => 'Nominal penarikan wajib diisi.',
            'amount.numeric' => 'Nominal harus berupa angka.',
            'amount.min' => 'Nominal minimal penarikan adalah Rp50.000.',

            'bank.required' => 'Nama bank wajib diisi.',
            'bank.string' => 'Nama bank harus berupa teks.',
            'bank.max' => 'Nama bank maksimal 50 karakter.',

            'number.required' => 'Nomor rekening wajib diisi.',
            'number.string' => 'Nomor rekening harus berupa teks.',
            'number.max' => 'Nomor rekening maksimal 30 karakter.',
        ]);

        $user = auth()->user();

        // Cek apakah role = 1
        if ($user->role != 1) {
            return redirect()->back()->withErrors(['Anda tidak memiliki akses untuk melakukan penarikan.']);
        }

        // Ambil data user_info
        $userInfo = UserInfo::firstOrCreate(
        ['user_id' => $user->user_id],
        [
                'address' => '-',
                'province' => '-',
                'city' => '-',
                'postal_code' => '-',
                'balance' => 0,
            ]
        );

        // Cek apakah saldo cukup
        if ($userInfo->balance < $request->amount) {
            return redirect()->back()->withErrors(['Saldo tidak mencukupi untuk penarikan ini.']);
        }

        // Kurangi saldo
        $userInfo->balance -= $request->amount;
        $userInfo->save();

        Withdrawal::create([
            'user_id' => auth()->id(),
            'withdrawal_balance' => $request->amount,
            'bank' => $request->bank,
            'number' => $request->number,
            'datetime' => now(),
        ]);

        return redirect()->back()->with('success', 'Permintaan penarikan berhasil diajukan.');
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
