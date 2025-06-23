<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? 1,
            'amount' => $this->faker->randomFloat(2, 5, 500),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }
}