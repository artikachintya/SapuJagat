<?php

namespace Database\Factories;

use App\Models\Trash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderDetail>
 */
use App\Models\OrderDetail;
use App\Models\Order;

class OrderDetailFactory extends Factory
{
    protected $model = OrderDetail::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'trash_id' => Trash::inRandomOrder()->first()?->trash_id ?? Trash::factory(),
            'quantity' => $this->faker->numberBetween(1, 100),
            // 'trash_id' => Trash::factory(),
            // 'trash_id' => Trash::inRandomOrder()->first()->trash_id,
            // 'quantity' => $this->faker->numberBetween(1, 100),
        ];
    }
}
