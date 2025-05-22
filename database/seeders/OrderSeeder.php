<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\User;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::pluck('user_id')->toArray();
        Order::create([
            'user_id' => $users[0], // pastikan user_id 1 sudah ada di tabel users
            'date_time_request' => Carbon::now(),
            'photo' => 'photos/order1.jpg',
            'status' => true,
        ]);

        Order::create([
            'user_id' => $users[1], // pastikan user_id 2 juga sudah ada
            'date_time_request' => Carbon::now()->addHours(2),
            'photo' => 'photos/order2.jpg',
            'status' => true,
        ]);
    }
}
