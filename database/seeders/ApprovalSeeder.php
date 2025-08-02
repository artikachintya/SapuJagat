<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Approval;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class ApprovalSeeder extends Seeder
{
    public function run(): void
    {
        // DB::table('approvals')->insert([
        //     [
        //         'order_id'        => 1,
        //         'user_id'         => 1,
        //         'date_time'       => now(),
        //         'approval_status' => true,
        //         'notes'           => 'Permintaan disetujui.',
        //     ],
        //     [
        //         'order_id'        => 2,
        //         'user_id'         => 1,
        //         'date_time'       => now(),
        //         'approval_status' => true,
        //         'notes'           => 'Permintaan disetujui.',
        //     ],
        // ]);
        // Approval::factory(10)->create();
        $orders = Order::inRandomOrder()->take(20)->get();
        $admins = User::where('role', 2)->get();
        $startDate = Carbon::create(2024, 8, 1);

        foreach ($orders as $order) {
            Approval::create([
                'order_id' => $order->order_id,
                'user_id' => $admins->random()->user_id,
                'date_time' => $startDate->copy()->addDays(rand(0, 29)),
                'approval_status' => true,
                'notes' => 'Permintaan disetujui.'
            ]);
        }
    }
}

