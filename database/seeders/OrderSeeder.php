<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Trash;
use App\Models\User;
use App\Models\Rating;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 20 order oleh user role 1
        $users = User::where('role', 1)->get();

        foreach ($users->take(20) as $user) {
            $order = Order::factory()->create(['user_id' => $user->user_id]);

            // 2-3 detail per order
            $trashes = Trash::inRandomOrder()->take(rand(2, 3))->get();
            foreach ($trashes as $trash) {
                OrderDetail::create([
                    'order_id' => $order->order_id,
                    'trash_id' => $trash->trash_id,
                    'quantity' => rand(1, 5)
                ]);
            }

            // Optional: tambahkan rating (misal 50% order punya rating)
            if (rand(0, 1)) {
                Rating::create([
                    'order_id' => $order->order_id,
                    'user_id' => $user->user_id,
                    'star_rating' => rand(1, 5)
                ]);
            }
        }
    }
}


// use Illuminate\Database\Seeder;
// use App\Models\Order;
// use Illuminate\Support\Facades\DB;
// use App\Models\User;

// class OrderSeeder extends Seeder
// {
//     public function run(): void
//     {
//         DB::table('orders')->insert([
//             [
//                 'user_id' => 1,
//                 'date_time_request' => now(),
//                 'photo' => 'photo1.jpg',
//                 'pickup_time' => '18.00 - 20.00 WIB',
//                 'status' => '1'
//             ],
//             [
//                 'user_id' => 2,
//                 'date_time_request' => now(),
//                 'photo' => 'photo2.jpg',
//                 'pickup_time' => '07.00 - 09.00 WIB',
//                 'status' => '0'
//             ],
//             [
//                 'user_id' => 3,
//                 'date_time_request' => now(),
//                 'photo' => 'photo2.jpg',
//                 'pickup_time' => '07.00 - 09.00 WIB',
//                 'status' => '0'
//             ],
//             [
//                 'user_id' => 4,
//                 'date_time_request' => now(),
//                 'photo' => 'photo2.jpg',
//                 'pickup_time' => '07.00 - 09.00 WIB',
//                 'status' => '0'
//             ],
//         ]);
//     }
// }

