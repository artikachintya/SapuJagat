<?php


namespace App\Http\Controllers\Pengguna;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreWithdrawalRequest;
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
            : 0;

        return view('pengguna.TarikSaldo', compact('totalBalance', 'monthlyWithdrawals'));
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
    public function store(StoreWithdrawalRequest $requests)
    {
        $request = $requests->validated();

        $user = auth()->user();

        if ($user->role != 1) {
            activity('update_saldo')
                ->causedBy($user)
                ->withProperties(['reason' => 'Role tidak diizinkan'])
                ->log('Gagal tarik saldo: role tidak diizinkan');

            return redirect()->back()->withErrors(['Anda tidak memiliki akses untuk melakukan penarikan.']);
        }

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

        if ($userInfo->balance < $request['amount']) {
            activity('update_saldo')
                ->causedBy($user)
                ->withProperties([
                    'attempted_amount' => $request['amount'],
                    'current_balance' => $userInfo->balance,
                ])
                ->log('Gagal tarik saldo: saldo tidak mencukupi');

            return redirect()->back()->withErrors(['Saldo tidak mencukupi untuk penarikan ini.']);
        }

        // Cek apakah saldo cukup
        if ($userInfo->balance < $request['amount']) {
            return redirect()->back()->withErrors(['Saldo tidak mencukupi untuk penarikan ini.']);
        }

        // Kurangi saldo
        $userInfo->balance -= $request['amount'];
        $userInfo->save();

        $withdrawal = Withdrawal::create([
            'user_id' => auth()->id(),
            'withdrawal_balance' => $request['amount'],
            'bank' => $request['bank'],
            'number' => $request['number'],
            'datetime' => now(),
        ]);

        activity('update_saldo')
            ->causedBy($user)
            ->performedOn($withdrawal)
            ->withProperties([
                'amount' => $request['amount'],
                'bank' => $request['bank'],
                'number' => $request['number'],
            ])
            ->log('Berhasil mengajukan penarikan saldo');


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
