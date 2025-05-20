<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chat;
use Carbon\Carbon;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chat::insert([
            ['date_time_created' => Carbon::now()],
            ['date_time_created' => Carbon::now()],
        ]);
    }
}
