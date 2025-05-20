<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'user_id' => 1, // pastikan user_id 1 sudah ada di tabel users
            'date_time_request' => Carbon::now(),
            'photo' => 'photos/order1.jpg',
            'status' => true,
        ]);

        Order::create([
            'user_id' => 2, // pastikan user_id 2 juga sudah ada
            'date_time_request' => Carbon::now()->addHours(2),
            'photo' => 'photos/order2.jpg',
            'status' => true,
        ]);
    }
}
