<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Withdrawal;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class WithdrawalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('withdrawals')->insert([
            [
                'withdrawal_id' => 1,
                'user_id' => 1,
                'withdrawal_balance' => 100000,
                'number'=>'201930112',
                'bank'=>'BCA',
                'datetime' => now(),
            ],
            [
                'withdrawal_id' => 2,
                'user_id' => 2,
                'withdrawal_balance' => 100000,
                'number'=>'31283120',
                'bank'=>'Mandiri',
                'datetime' => now(),
            ],
        ]);
    }
}

