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
        // DB::table('pick_ups')->insert([
        //     [
        //         'pick_up_id' => 1,
        //         'order_id' => 1,
        //         // 'user_id' => 1,
        //         'user_id' => 5,
        //         // 'photos' => 'pickup1.jpg',
        //         'notes' => 'Sukses diambil',
        //     ],
        //     [
        //         'pick_up_id' => 2,
        //         'order_id' => 2,
        //         // 'user_id' => 2,
        //         'user_id' => 6,
        //         // 'photos' => 'pickup2.jpg',
        //         'notes' => 'Sukses diambil',
        //     ],
        // ]);
        PickUp::factory(5)->create();
    }
}
