<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderDetail;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderDetail::create([
            'order_id' => 1, // pastikan order_id 1 ada
            'trash_id' => 1, // pastikan trash_id 1 ada
            'quantity' => 2,
        ]);

        OrderDetail::create([
            'order_id' => 1,
            'trash_id' => 2,
            'quantity' => 5,
        ]);

        OrderDetail::create([
            'order_id' => 2,
            'trash_id' => 6,
            'quantity' => 1,
        ]);
    }
}
