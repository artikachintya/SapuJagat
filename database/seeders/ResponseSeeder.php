<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Response;

class ResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Response::create([
            'admin_id' => 1, // Pastikan admin dengan ID 1 ada
            'report_id' => 1, // Pastikan report dengan ID 1 ada
            'response_message' => 'Terima kasih atas laporannya. Kami akan menindaklanjuti secepatnya.',
        ]);
    }
}
