<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// class UserSeeder extends Seeder
// {
//     public function run(): void
//     {
//         User::create([
//             'name' => 'John Carter',
//             'NIK' => '3273010101010001', // Pria, lahir 1 Jan 2001
//             'email' => 'user1@example.com',
//             'address' => 'CitraLand 2A',
//             'province' => 'Jawa Barat',
//             'city' => 'Bandung',
//             'postal_code' => '60232',
//             'phone_num' => '081234567890',
//             'password' => Hash::make('Password123'),
//             'status' => true,
//             'balance' => 100000,
//         ]);

//         User::create([
//             'name' => 'Alice Moore',
//             'NIK' => '3273015002010002', // Wanita, lahir 10 Feb 2001 (10+40=50)
//             'email' => 'user2@example.com',
//             'address' => 'CitraHarmony 12A',
//             'province' => 'Jawa Timur',
//             'city' => 'Surabaya',
//             'postal_code' => '60110',
//             'phone_num' => '081298765432',
//             'password' => Hash::make('Password123'),
//             'status' => true,
//             'balance' => 50000,
//         ]);
//     }
// }

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID terakhir
        $last = User::orderBy('user_id', 'desc')->first();
        $nextNumber = $last ? ((int)substr($last->user_id, 1)) + 1 : 1;

        $users = [
            [
                'name' => 'John Carter',
                'NIK' => '3273010101010001',
                'email' => 'user1@example.com',
                'address' => 'CitraLand 2A',
                'province' => 'Jawa Barat',
                'city' => 'Bandung',
                'postal_code' => '60232',
                'phone_num' => '081234567890',
                'balance' => 100000,
            ],
            [
                'name' => 'Alice Moore',
                'NIK' => '3273015002010002',
                'email' => 'user2@example.com',
                'address' => 'CitraHarmony 12A',
                'province' => 'Jawa Timur',
                'city' => 'Surabaya',
                'postal_code' => '60110',
                'phone_num' => '081298765432',
                'balance' => 50000,
            ],
        ];

        foreach ($users as $index => $data) {
            $userId = 'U' . str_pad($nextNumber + $index, 3, '0', STR_PAD_LEFT); // U001, U002, ...

            User::create([
                'user_id'     => $userId,
                'name'        => $data['name'],
                'NIK'         => $data['NIK'],
                'email'       => $data['email'],
                'address'     => $data['address'],
                'province'    => $data['province'],
                'city'        => $data['city'],
                'postal_code' => $data['postal_code'],
                'phone_num'   => $data['phone_num'],
                'password'    => Hash::make('Password123'),
                'status'      => true,
                'balance'     => $data['balance'],
            ]);
        }
    }
}
