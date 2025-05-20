<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Approval;
use Carbon\Carbon;

class ApprovalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Approval::create([
            'order_id' => 1, // Pastikan order dengan ID 1 ada
            'date_time' => Carbon::now(),
            'approval_status' => true,
            'notes' => 'Permintaan penjemputan disetujui.',
        ]);

        Approval::create([
            'order_id' => 2,
            'date_time' => Carbon::now()->addMinutes(10),
            'approval_status' => false,
            'notes' => 'Data penjemputan kurang lengkap.',
        ]);
    }
}
