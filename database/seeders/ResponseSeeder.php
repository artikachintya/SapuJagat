<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Response;
use App\Models\Admin; // <-- ini yang kurang

class ResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

            // 'admin_id' => 1, // Pastikan admin dengan ID 1 ada
            // 'report_id' => 1, // Pastikan report dengan ID 1 ada
            // 'response_message' => 'Terima kasih atas laporannya. Kami akan menindaklanjuti secepatnya.',
             // Ambil admin pertama (bisa juga pakai where jika mau spesifik)
        $admin = Admin::first();

        // Pastikan admin ditemukan
        if (!$admin) {
            echo "Admin belum ada di database. Jalankan AdminSeeder dulu.\n";
            return;
        }

        Response::create([
                'admin_id' => $admin->admin_id, // sekarang tidak undefined
                'report_id' => 1,
                'response_message' => 'Terima kasih atas laporannya. Kami akan menindaklanjuti secepatnya.',
        ]);
    }
}
