<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rating;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rating::create([
            'order_id' => 1, // Pastikan order_id 1 ada
            'user_id' => 1,  // Pastikan user_id 1 ada
            'star_rating' => 4,
        ]);

        Rating::create([
            'order_id' => 2,
            'user_id' => 2,
            'star_rating' => 5,
        ]);
    }
}
