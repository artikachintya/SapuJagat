<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Report;
use App\Models\User;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::pluck('user_id')->toArray();
        Report::Create([
            'user_id' => $users[0],
            'date_time_report' => Carbon::now(),
            'photo' => 'photos/keluhan1.jpg',
            'report_message' => 'Poin saya tiba-tiba hilang setelah tukar sampah.',
        ]);
    }
}
