<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PenugasanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penugasans')->insert([
            [
                'order_id' => 3,
                'user_id' => 5,
                'created_at' => now(),
                'status'=>0,
            ],
        ]);
    }
}

