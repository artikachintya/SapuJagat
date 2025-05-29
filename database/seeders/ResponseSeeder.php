<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Response;

class ResponseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Response::create([
            'user_id' => 3, // misalnya admin atau petugas CS
            'report_id' => 1,
            'response_message' => 'Kami mohon maaf atas keterlambatan. Akan segera ditindaklanjuti.',
            'date_time_response'=> now()
        ]);

        \App\Models\Response::create([
            'user_id' => 4,
            'report_id' => 2,
            'response_message' => 'Terima kasih atas laporan Anda. Kami akan evaluasi pengemudi tersebut.',
            'date_time_response'=> now()
        ]);
    }
}

