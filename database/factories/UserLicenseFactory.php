<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserLicenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'license_plate' => strtoupper($this->faker->bothify('??####??')),
        ];
    }
}
