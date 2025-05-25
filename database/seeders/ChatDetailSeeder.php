<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChatDetail;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ChatDetailSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('chat_details')->insert([
            [
                'chat_detail_id' => 1,
                'user_id' => 1,
                'chat_id' => 1,
                'detail_chat' => 'Halo, ini saya sudah didepan pagar ya pak.',
                'photos' => 'chat1.jpg',
                'date_time' => now(),
            ],
            [
                'chat_detail_id' => 2,
                'user_id' => 5,
                'chat_id' => 1,
                'detail_chat' => 'Halo user1, saya driver sudah otw menuju kesana ya.',
                'photos' => 'chat2.jpg',
                'date_time' => now(),
            ],
        ]);
    }
}
