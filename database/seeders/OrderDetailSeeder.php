<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\OrderDetail;

class OrderDetailSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_details')->insert([
            [
                'order_id' => 1,
                'trash_id' => 1,
                'quantity' => 5,
            ],
            [
                'order_id' => 1,
                'trash_id' => 2,
                'quantity' => 3,
            ],
            [
                'order_id' => 2,
                'trash_id' => 6,
                'quantity' => 1,
            ],
        ]);
    }
}
