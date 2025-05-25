<?php

namespace Database\Seeders;

use App\Models\Chat;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('chats')->insert([
            [
                'chat_id' => 1,
                'date_time_created' => now(),
            ],
            [
                'chat_id' => 2,
                'date_time_created' => now(),
            ],
        ]);
    }
}

