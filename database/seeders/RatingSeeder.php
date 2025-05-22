<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rating;
use App\Models\User;
class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::pluck('user_id')->toArray();
        Rating::create([
            'order_id' => 1, // Pastikan order_id 1 ada
            'user_id' => $users[0],  // Pastikan user_id 1 ada
            'star_rating' => 4,
        ]);

        Rating::create([
            'order_id' => 2,
            'user_id' => $users[1],
            'star_rating' => 5,
        ]);
    }
}
