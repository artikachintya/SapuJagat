<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserInfo>
 */
class UserInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // `user_id` will be filled from UserFactory, so leave it out here
            'address'     => $this->faker->address,
            'province'    => $this->faker->state,
            'city'        => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'balance'     => 0,
        ];
    }
}
