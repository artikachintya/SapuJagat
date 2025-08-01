<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\OrderDetail;
use App\Models\Trash;
use App\Models\Order;

class OrderDetailSeeder extends Seeder
{
    public function run(): void
    {
        // // Pastikan sudah ada Trash dan Order dulu
        // if (Trash::count() === 0) {
        //     \App\Models\Trash::factory()->count(10)->create();
        // }

        // if (Order::count() === 0) {
        //     \App\Models\Order::factory()->count(20)->create();
        // }

        // // Seed order_detail
        // OrderDetail::factory()->count(50)->create();
        // $orders = Order::all();

        // foreach ($orders as $order) {
        //     OrderDetail::factory()->create([
        //         'order_id' => $order->order_id,
        //         'trash_id' => Trash::inRandomOrder()->first()->trash_id,
        //     ]);
        // }

        $orders = Order::all();

    foreach ($orders as $order) {
        $trashes = Trash::inRandomOrder()->take(rand(1, 3))->get();

        foreach ($trashes as $trash) {
            // Cek apakah kombinasi sudah ada, hindari duplikat
            $exists = OrderDetail::where('order_id', $order->order_id)
                ->where('trash_id', $trash->trash_id)
                ->exists();

            if (!$exists) {
                OrderDetail::create([
                    'order_id' => $order->order_id,
                    'trash_id' => $trash->trash_id,
                    'quantity' => rand(1, 5),
                ]);
            }
        }
    }
    }
}
