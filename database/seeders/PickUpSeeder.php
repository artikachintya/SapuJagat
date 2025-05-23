<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PickUp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PickUpSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pick_ups')->insert([
            [
                'pick_up_id' => 1,
                'order_id' => 1,
                'user_id' => 1,
                'pick_up_date' => now(),
                'arrival_date' => now()->addHours(2),
                'photos' => 'pickup1.jpg',
                'notes' => 'Sukses diambil',
            ],
            [
                'pick_up_id' => 2,
                'order_id' => 2,
                'user_id' => 2,
                'pick_up_date' => now(),
                'arrival_date' => now()->addHours(1),
                'photos' => 'pickup2.jpg',
                'notes' => 'Sukses diambil',
            ],
        ]);
    }
}
