<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PickUp;
use Carbon\Carbon;

class PickUpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PickUp::create([
            'order_id' => 1,     // pastikan order_id 1 ada
            'driver_id' => 1,    // pastikan driver_id 1 ada di tabel drivers
            'pick_up_date' => Carbon::now(),
            'arrival_date' => Carbon::now()->addMinutes(30),
            'photos' => 'photos/pickup1.jpg',
            'notes' => 'Sampah berhasil diambil dari rumah pelanggan.',
        ]);

        PickUp::create([
            'order_id' => 2,
            'driver_id' => 2,
            'pick_up_date' => Carbon::now()->addHour(),
            'arrival_date' => Carbon::now()->addHours(2),
            'photos' => 'photos/pickup2.jpg',
            'notes' => 'Driver mengalami sedikit keterlambatan karena hujan.',
        ]);
    }
}
