<?php

namespace Database\Seeders;

use App\Models\UserLicense;
use Illuminate\Database\Seeder;
// 1. Pastikan use statement ini tetap ada
use Spatie\Activitylog\ActivitylogStatus;

// ... (use statement untuk model lainnya)

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 2. Panggil kelas menggunakan helper app() untuk menonaktifkan log
        app(ActivitylogStatus::class)->disable();

        $this->call([
            UserSeeder::class,
            // UserLicense::class,
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

        // 3. Aktifkan kembali log dengan cara yang sama
        app(ActivitylogStatus::class)->enable();
    }
}
