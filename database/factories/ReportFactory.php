<?php

namespace Database\Factories;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'user_id' => User::inRandomOrder()->first()->id,
            'user_id' => User::factory(),
            'date_time_report' => now(),
            'photo' => $this->faker->imageUrl(),
            'report_message' => $this->faker->sentence,
        ];
    }
}
