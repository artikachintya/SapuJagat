<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        // DB::table('ratings')->insert([
        //     [
        //         'order_id' => 1,
        //         'user_id' => 1,
        //         'star_rating' => 4,
        //     ],
        //     [
        //         'order_id' => 2,
        //         'user_id' => 2,
        //         'star_rating' => 5,
        //     ],
        // ]);
        Rating::factory()->count(10)->create();
    }
}

