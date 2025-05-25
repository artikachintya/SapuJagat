<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'user_id' => 1,
                'date_time_request' => now(),
                'photo' => 'photo1.jpg',
                'status' => true,
            ],
            [
                'user_id' => 2,
                'date_time_request' => now(),
                'photo' => 'photo2.jpg',
                'status' => false,
            ],
        ]);
    }
}

