<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Withdrawal;
use Carbon\Carbon;

class WithdrawalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Withdrawal::create([
            'user_id' => 1, // pastikan user_id = 1 ada di tabel users
            'withdrawal_balance' => 50000,
            'datetime' => Carbon::now(),
        ]);

        Withdrawal::create([
            'user_id' => 2,
            'withdrawal_balance' => 75000,
            'datetime' => Carbon::now()->subDays(1),
        ]);
    }
}
