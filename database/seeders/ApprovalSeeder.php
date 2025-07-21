<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Approval;
use Carbon\Carbon;

class ApprovalSeeder extends Seeder
{
    public function run(): void
    {
        // DB::table('approvals')->insert([
        //     [
        //         'order_id'        => 1,
        //         'user_id'         => 1,
        //         'date_time'       => now(),
        //         'approval_status' => true,
        //         'notes'           => 'Permintaan disetujui.',
        //     ],
        //     [
        //         'order_id'        => 2,
        //         'user_id'         => 1,
        //         'date_time'       => now(),
        //         'approval_status' => true,
        //         'notes'           => 'Permintaan disetujui.',
        //     ],
        // ]);
        Approval::factory(10)->create();
    }
}

