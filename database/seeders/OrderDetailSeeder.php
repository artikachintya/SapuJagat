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
        // Pastikan sudah ada Trash dan Order dulu
        if (Trash::count() === 0) {
            \App\Models\Trash::factory()->count(10)->create();
        }

        if (Order::count() === 0) {
            \App\Models\Order::factory()->count(20)->create();
        }

        // Seed order_detail
        OrderDetail::factory()->count(50)->create();
    }
}
