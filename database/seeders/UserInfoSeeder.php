<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\UserInfo;

class UserInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('users_info')->insert([
        //     [
        //         'user_id'    => 1,
        //         'address'    => 'Jl. Merdeka No.1',
        //         'province'   => 'DKI Jakarta',
        //         'city'       => 'Jakarta Pusat',
        //         'postal_code'=> '10110',
        //         'balance'    => 150000,
        //     ],
        //     [
        //         'user_id'    => 2,
        //         'address'    => 'Jl. Kebangsaan No.2',
        //         'province'   => 'Jawa Barat',
        //         'city'       => 'Bandung',
        //         'postal_code'=> '40234',
        //         'balance'    => 100000,
        //     ],
        //     [
        //         'user_id'    => 7,
        //         'address'    => 'Jl. Kekanak-kanakan No.2',
        //         'province'   => 'Jawa Timur',
        //         'city'       => 'Jambi',
        //         'postal_code'=> '40382',
        //         'balance'    => 1000000,
        //     ],
        // ]);
    }
}
