<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\Report;
use App\Models\User;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Report::create([
            'user_id' => 1, // pastikan user_id ini sudah ada di tabel users
            'date_time_report' => Carbon::now(),
            'photo' => 'report1.jpg',
            'report_message' => 'Sampah tidak diambil tepat waktu.'
        ]);

        \App\Models\Report::create([
            'user_id' => 2,
            'date_time_report' => Carbon::now()->subDays(1),
            'photo' => 'report2.jpg',
            'report_message' => 'Pengemudi tidak ramah.'
        ]);
    }
}

