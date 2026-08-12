<?php

namespace Database\Factories;

use App\Models\SavingsContribution;
use App\Models\SavingsGoal;
use Illuminate\Database\Eloquent\Factories\Factory;

class SavingsContributionFactory extends Factory
{
    protected $model = SavingsContribution::class;

    public function definition(): array
    {
        $goal = SavingsGoal::factory()->create();

        return [
            'savings_goal_id' => $goal->id,
            'invitation_id' => $goal->invitation_id,
            'contributor_id' => $goal->user_id,
            'user_id' => $goal->user_id,
            'amount' => fake()->numberBetween(100000, 1000000),
            'currency' => 'IDR',
            'method' => fake()->randomElement(['transfer', 'e-wallet', 'cash', 'card']),
            'contributed_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'note' => fake()->sentence,
            'is_automatic' => false,
        ];
    }
}
