<?php

namespace Database\Factories;

use App\Models\Trash;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrashFactory extends Factory
{
    protected $model = Trash::class;

    public function definition()
    {
        return [
            // 'name' => $this->faker->word,
            // 'type' => $this->faker->randomElement(['Organik', 'Anorganik']),
            // 'price_per_kg' => $this->faker->randomFloat(2, 1000, 100000),
            // 'max_weight' => $this->faker->numberBetween(10, 100),
            // 'photos' => 'lainnya.jpg',
            // // 'photos' => '-',
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['Organik', 'Anorganik']),
            'price_per_kg' => $this->faker->randomFloat(2, 1000, 100000),
            'max_weight' => 10, // SET FIXED VALUE
            'photos' => 'lainnya.jpg',
        ];
    }
}
