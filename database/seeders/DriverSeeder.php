<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Driver;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // Ambil ID terakhir
        // $last = Driver::orderBy('driver_id', 'desc')->first();
        // $nextNumber = $last ? ((int)substr($last->driver_id, 1)) + 1 : 1;

        // // Loop masukin driver
        // for ($i = 0; $i < 2; $i++) {
        //     $id = 'D' . str_pad($nextNumber + $i, 3, '0', STR_PAD_LEFT); // D001, D002, dst.

        //     Driver::create([
        //         'driver_id' => $id,
        //         'name' => 'Driver1',
        //         'email' => 'driver1@example.com',
        //         'password' => Hash::make('driver123'),
        //         'status' => true,
        //         'license_plate' => 'B1234XYZ',
        //     ]);
        //     Driver::create([
        //         'driver_id' => $id,
        //         'name' => 'Driver2',
        //         'email' => 'driver2@example.com',
        //         'password' => Hash::make('driver123'),
        //         'status' => true,
        //         'license_plate' => 'B1234XYW',
        //     ]);
        // }
        $last = Driver::orderBy('driver_id', 'desc')->first();
        $nextNumber = $last ? ((int)substr($last->driver_id, 1)) + 1 : 1;

        $drivers = [
            ['name' => 'Driver1', 'email' => 'driver1@example.com', 'license_plate' => 'B1234XYZ'],
            ['name' => 'Driver2', 'email' => 'driver2@example.com', 'license_plate' => 'B1234XYW'],
        ];

        foreach ($drivers as $index => $data) {
            $id = 'D' . str_pad($nextNumber + $index, 3, '0', STR_PAD_LEFT);

            Driver::create([
                'driver_id' => $id,
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('driver123'),
                'status' => true,
                'license_plate' => $data['license_plate'],
            ]);
        }
    }
}
