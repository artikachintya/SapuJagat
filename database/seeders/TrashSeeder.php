<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Trash;

class TrashSeeder extends Seeder
{
    public function run(): void
    {
        Trash::insert([
           // Sampah Organik
            [
                'name' => 'Sisa Makanan',
                'type' => 'Organik',
                'price_per_kg' => 1000,
                'max_weight' => 10,
            ],
            [
                'name' => 'Kulit Buah',
                'type' => 'Organik',
                'price_per_kg' => 1200,
                'max_weight' => 10,
            ],
            [
                'name' => 'Daun Kering',
                'type' => 'Organik',
                'price_per_kg' => 800,
                'max_weight' => 10,
            ],
            [
                'name' => 'Ampas Kopi',
                'type' => 'Organik',
                'price_per_kg' => 900,
                'max_weight' => 10,
            ],
            [
                'name' => 'Cangkang Telur',
                'type' => 'Organik',
                'price_per_kg' => 1100,
                'max_weight' => 10,
            ],

            // Sampah Anorganik
            [
                'name' => 'Botol Plastik',
                'type' => 'Anorganik',
                'price_per_kg' => 3000,
                'max_weight' => 10,
            ],
            [
                'name' => 'Kaleng',
                'type' => 'Anorganik',
                'price_per_kg' => 5000,
                'max_weight' => 10,
            ],
            [
                'name' => 'Kardus',
                'type' => 'Anorganik',
                'price_per_kg' => 2000,
                'max_weight' => 10,
            ],
            [
                'name' => 'Kaca Pecah',
                'type' => 'Anorganik',
                'price_per_kg' => 2500,
                'max_weight' => 10,
            ],
            [
                'name' => 'Styrofoam',
                'type' => 'Anorganik',
                'price_per_kg' => 1500,
                'max_weight' => 10,
            ],
        ]);
    }
}

