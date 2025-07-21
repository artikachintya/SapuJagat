<?php

namespace Database\Factories;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Withdrawal>
 */
class WithdrawalFactory extends Factory
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
            'withdrawal_balance' => $this->faker->numberBetween(50000, 200000),
            'number' => $this->faker->bankAccountNumber,
            'bank' => $this->faker->randomElement(['BCA', 'Mandiri', 'BRI', 'BNI']),
            'datetime' => now(),
        ];
    }
}
