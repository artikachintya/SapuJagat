<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Report;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Report::Create([
            'user_id' => 1,
            'date_time_report' => Carbon::now(),
            'photo' => 'photos/keluhan1.jpg',
            'report_message' => 'Poin saya tiba-tiba hilang setelah tukar sampah.',
        ]);
    }
}
