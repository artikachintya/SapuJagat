<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'date_time_report' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'photo' => null,
            'report_message' => $this->faker->sentence,
        ];
    }
}