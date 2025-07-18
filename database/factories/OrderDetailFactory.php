<?php

namespace Database\Factories;

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
            'trash_id' => $this->faker->numberBetween(1, 10), // adjust as needed
            'quantity' => $this->faker->numberBetween(1, 5),
        ];
    }
}
