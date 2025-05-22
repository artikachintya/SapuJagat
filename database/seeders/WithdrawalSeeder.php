<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Withdrawal;
use Carbon\Carbon;
use App\Models\User;

class WithdrawalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::pluck('user_id')->toArray();
        
        Withdrawal::create([
            'user_id' => $users[0], // pastikan user_id = 1 ada di tabel users
            'withdrawal_balance' => 50000,
            'datetime' => Carbon::now(),
        ]);

        Withdrawal::create([
            'user_id' => $users[1],
            'withdrawal_balance' => 75000,
            'datetime' => Carbon::now()->subDays(1),
        ]);
    }
}
