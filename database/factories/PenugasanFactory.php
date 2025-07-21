<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Pickup;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenugasanFactory extends Factory
{
    protected $model = \App\Models\Penugasan::class;

    public function definition(): array
    {
        return [
            'order_id'   => Order::factory(),
            'user_id'    => User::factory()->create(['role' => 3])->user_id,
            'status'     => $this->faker->randomElement([0, 1]),
            'created_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Penugasan $penugasan) {
            Pickup::factory()->create([
                'order_id'      => $penugasan->order_id,
                'user_id'       => $penugasan->user_id,
                'penugasan_id'  => $penugasan->penugasan_id,
            ]);
        });
    }
}
