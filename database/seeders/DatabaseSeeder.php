<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Driver;
use App\Models\Trash;
use App\Models\Report;
use App\Models\ChatDetail;
use App\Models\Response;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            DriverSeeder::class,
            TrashSeeder::class,
            ChatSeeder::class,
            ReportSeeder::class,
            WithdrawalSeeder::class,
            ChatDetailSeeder::class,
            OrderSeeder::class,
            PickUpSeeder::class,
            ResponseSeeder::class,
            ApprovalSeeder::class,
            OrderDetailSeeder::class,
            RatingSeeder::class,
        ]);
    }
}
