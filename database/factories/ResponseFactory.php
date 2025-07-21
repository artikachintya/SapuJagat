<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Response>
 */// database/factories/ResponseFactory.php

use App\Models\Response;
use App\Models\Report;
use App\Models\User;

class ResponseFactory extends Factory
{
    protected $model = Response::class;

    public function definition()
    {
        return [
            'report_id' => Report::factory(),
            'user_id' => User::factory(['role' => 2]), // Assuming role 2 is admin
            'response_message' => $this->faker->sentence,
            'date_time_response' => now(),
        ];
    }
}

