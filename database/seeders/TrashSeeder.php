<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Trash;


class TrashSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('trashes')->insert([
            [
                'trash_id' => 1,
                'name' => 'Sisa Makanan',
                'type' => 'Organik',
                'price_per_kg' => 1000,
                'max_weight' => 10,
            ],
            [
                'trash_id' => 2,
                'name' => 'Kulit Buah',
                'type' => 'Organik',
                'price_per_kg' => 1200,
                'max_weight' => 10,
            ],
            [
                'trash_id' => 3,
                'name' => 'Daun Kering',
                'type' => 'Organik',
                'price_per_kg' => 800,
                'max_weight' => 10,
            ],
            [
                'trash_id' => 4,
                'name' => 'Kulit Buah',
                'type' => 'Organik',
                'price_per_kg' => 1200,
                'max_weight' => 10,
            ],
            [
                'trash_id' => 5,
                'name' => 'Cangkang Telur',
                'type' => 'Organik',
                'price_per_kg' => 1100,
                'max_weight' => 10,
            ],
            [
                'trash_id' => 6,
                'name' => 'Botol Plastik',
                'type' => 'Anorganik',
                'price_per_kg' => 3000,
                'max_weight' => 10,
            ],
            [
                'trash_id' => 7,
                'name' => 'Kaleng',
                'type' => 'Anorganik',
                'price_per_kg' => 5000,
                'max_weight' => 10,
            ],
            [
                'trash_id' => 8,
                'name' => 'Kardus',
                'type' => 'Anorganik',
                'price_per_kg' => 2000,
                'max_weight' => 10,
            ],
            [
                'trash_id' => 9,
                'name' => 'Kaca Pecah',
                'type' => 'Anorganik',
                'price_per_kg' => 2500,
                'max_weight' => 10,
            ],
            [
                'trash_id' => 10,
                'name' => 'Styrofoam',
                'type' => 'Anorganik',
                'price_per_kg' => 1500,
                'max_weight' => 10,
            ],
        ]);
    }
}
