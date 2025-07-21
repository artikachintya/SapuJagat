<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserInfoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'address' => $this->faker->address(),
            'province' => $this->faker->state(),
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
            'balance' => $this->faker->numberBetween(10000, 1000000),
        ];
    }
}

