<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;


// class AdminSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         // Admin::create([
//         //     'name' => 'Admin1',
//         //     'email' => 'admin1@example.com',
//         //     'password' => Hash::make('admin123'),
//         // ]);

//         // Hitung total admin yang ada
//         $lastId = Admin::orderBy('admin_id', 'desc')->first();
//         $newNumber = $lastId ? ((int)substr($lastId->admin_id, 1)) + 1 : 1;
//         $newId = 'A' . str_pad($newNumber, 3, '0', STR_PAD_LEFT); // A0001, A0002

//         Admin::create([
//             'admin_id' => $newId,
//             'name' => 'Admin1',
//             'email' => 'admin1@example.com',
//             'password' => Hash::make('admin123'),
//         ]);

//         Admin::create([
//             'admin_id' => $newId,
//             'name' => 'Admin2',
//             'email' => 'admin2@example.com',
//             'password' => Hash::make('admin123'),
//         ]);
//     }
// }

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil admin terakhir berdasarkan urutan admin_id
        $last = Admin::orderBy('admin_id', 'desc')->first();
        $nextNumber = $last ? ((int)substr($last->admin_id, 1)) + 1 : 1;

        // Daftar admin yang akan ditambahkan
        $admins = [
            ['name' => 'Admin1', 'email' => 'admin1@example.com'],
            ['name' => 'Admin2', 'email' => 'admin2@example.com'],
            ['name' => 'Admin3', 'email' => 'admin3@example.com'],
        ];

        // Loop untuk membuat data admin baru
        foreach ($admins as $index => $data) {
            $id = 'A' . str_pad($nextNumber + $index, 3, '0', STR_PAD_LEFT); // A001, A002, dst.

            Admin::create([
                'admin_id' => $id,
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('admin123'),
            ]);
        }
    }
}
