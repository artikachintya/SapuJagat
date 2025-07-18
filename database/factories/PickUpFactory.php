<?php

namespace Database\Factories;

use App\Models\PickUp;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PickUpFactory extends Factory
{
    protected $model = PickUp::class;

    public function definition(): array
    {
        return [
            'order_id'     => Order::factory(), // creates related order
            'user_id'      => User::factory(),  // creates related user
            'start_time'   => $this->faker->dateTimeBetween('-2 days', 'now'),
            'pick_up_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'arrival_date' => $this->faker->optional()->dateTimeBetween('now', '+2 weeks'),
            'photos'       => $this->faker->imageUrl(),
            'notes'        => $this->faker->sentence(),
        ];
    }
}

