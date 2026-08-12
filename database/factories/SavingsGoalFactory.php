<?php

namespace Database\Factories;

use App\Models\Invitation;
use App\Models\SavingsGoal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SavingsGoalFactory extends Factory
{
    protected $model = SavingsGoal::class;

    public function definition(): array
    {
        return [
            'invitation_id' => Invitation::factory(),
            'user_id' => User::factory(),
            'name' => fake()->randomElement(['Venue', 'Honeymoon', 'Attendants', 'Dress', 'Dokumentasi']),
            'target_amount' => fake()->numberBetween(5000000, 50000000),
            'currency' => 'IDR',
            'deadline' => fake()->dateTimeBetween('+30 days', '+365 days')->format('Y-m-d'),
            'colour' => fake()->hexColor(),
            'description' => fake()->sentence,
            'auto_savings_rule' => null,
            'is_active' => true,
            'is_shared' => true,
        ];
    }
}
