<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChatDetail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Driver;


class ChatDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     ChatDetail::create([
    //         'chat_id' => 1, // pastikan chat_id 1 ada di tabel chats
    //         'detail_chat' => 'Halo, saya sudah di depan pagar ya pak',
    //         'photos' => 'photos/chat1.jpg',
    //         'date_time' => Carbon::now(),
    //     ]);

    //     ChatDetail::create([
    //         'chat_id' => 1,
    //         'detail_chat' => 'Baik saya kesana sekarang, saya masih di pertigaan',
    //         'photos' => 'photos/chat2.jpg',
    //         'date_time' => Carbon::now()->addMinutes(3),
    //     ]);
    // }

     public function run(): void
    {
        $userId = User::pluck('user_id')->first();   // Ambil user_id pertama
        $driverId = Driver::pluck('driver_id')->first(); // Ambil driver_id pertama

        ChatDetail::create([
            'chat_id' => 1,
            'user_id' => $userId,
            'driver_id' => null,
            'detail_chat' => 'Halo, saya sudah di depan pagar ya pak',
            'photos' => 'photos/chat1.jpg',
            'date_time' => Carbon::create(2025, 5, 22, 8, 50, 57),
        ]);

        ChatDetail::create([
            'chat_id' => 1,
            'user_id' => null,
            'driver_id' => $driverId,
            'detail_chat' => 'Baik saya kesana sekarang, saya masih di pertigaan',
            'photos' => 'photos/chat2.jpg',
            'date_time' => Carbon::create(2025, 5, 22, 8, 53, 57),
        ]);
    }
}
