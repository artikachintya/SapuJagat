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
        Driver::create([
            'name' => 'Driver1',
            'email' => 'driver1@example.com',
            'password' => Hash::make('driver123'),
            'status' => true,
            'license_plate' => 'B1234XYZ',
        ]);
        Driver::create([
            'name' => 'Driver2',
            'email' => 'driver2@example.com',
            'password' => Hash::make('driver123'),
            'status' => true,
            'license_plate' => 'B1234XYW',
        ]);
    }
}
