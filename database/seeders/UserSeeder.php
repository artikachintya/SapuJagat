<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'John Carter',
            'NIK' => '3273010101010001', // Pria, lahir 1 Jan 2001
            'email' => 'user1@example.com',
            'address' => 'CitraLand 2A',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'postal_code' => '60232',
            'phone_num' => '081234567890',
            'password' => Hash::make('Password123'),
            'status' => true,
            'balance' => 100000,
        ]);

        User::create([
            'name' => 'Alice Moore',
            'NIK' => '3273015002010002', // Wanita, lahir 10 Feb 2001 (10+40=50)
            'email' => 'user2@example.com',
            'address' => 'CitraHarmony 12A',
            'province' => 'Jawa Timur',
            'city' => 'Surabaya',
            'postal_code' => '60110',
            'phone_num' => '081298765432',
            'password' => Hash::make('Password123'),
            'status' => true,
            'balance' => 50000,
        ]);
    }
}

