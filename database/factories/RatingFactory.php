<?php

namespace Database\Factories;
use App\Models\Rating;
use App\Models\Order;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    // protected $model = Rating::class;
    // /**
    //  * Define the model's default state.
    //  *
    //  * @return array<string, mixed>
    //  */
    // public function definition(): array
    // {
    //     return [
    //         // 'order_id' => Order::inRandomOrder()->first()->order_id,
    //         // 'user_id' => User::where('role', 1)->inRandomOrder()->first()->user_id,
    //         'star_rating' => $this->faker->numberBetween(1, 5),
    //     ];
    // }
    protected $model = Rating::class;

    public function definition(): array
    {
        $order = Order::inRandomOrder()->first();
        $user = User::where('role', 1)->inRandomOrder()->first();

        return [
            'order_id' => $order ? $order->order_id : null,
            'user_id' => $user ? $user->user_id : null,
            'star_rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}
