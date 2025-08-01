<?php

namespace Database\Factories;

use App\Models\Approval;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApprovalFactory extends Factory
{
    protected $model = Approval::class;

    public function definition(): array
    {
        return [
            // 'order_id' => Order::factory(),
            // 'user_id' => User::factory(),
            // 'date_time' => now(),
            // 'approval_status' => $this->faker->boolean,
            // 'notes' => $this->faker->sentence,
            'date_time' => now()->setDate(2025, 8, rand(1, 28)),
            'approval_status' => $this->faker->boolean(70), // 70% disetujui
            'notes' => $this->faker->sentence,
        ];
    }
}
