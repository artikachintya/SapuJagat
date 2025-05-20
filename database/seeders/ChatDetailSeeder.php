<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChatDetail;
use Carbon\Carbon;

class ChatDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChatDetail::create([
            'chat_id' => 1, // pastikan chat_id 1 ada di tabel chats
            'detail_chat' => 'Halo, saya sudah di depan pagar ya pak',
            'photos' => 'photos/chat1.jpg',
            'date_time' => Carbon::now(),
        ]);

        ChatDetail::create([
            'chat_id' => 1,
            'detail_chat' => 'Baik saya kesana sekarang, saya masih di pertigaan',
            'photos' => 'photos/chat2.jpg',
            'date_time' => Carbon::now()->addMinutes(3),
        ]);
    }
}
