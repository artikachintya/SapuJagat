<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Trash;
use App\Models\Report;
use App\Models\ChatDetail;
use App\Models\Response;
use App\Models\UserInfo;
use App\Models\UserLicense;
use App\Models\Withdrawal;
use App\Models\Rating;
use App\Models\PickUp;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Chat;
use App\Models\Approval;

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
            // UserInfoSeeder::class,
            // UserLicenseSeeder::class,
            // AdminSeeder::class,
            // DriverSeeder::class,
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
            PenugasanSeeder::class,
        ]);
    }
}
