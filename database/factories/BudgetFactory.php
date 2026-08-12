<?php

namespace Database\Factories;

use App\Models\Budget;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetFactory extends Factory
{
    protected $model = Budget::class;

    public function definition(): array
    {
        return [
            'invitation_id' => Invitation::factory(),
            'user_id' => User::factory(),
            'title' => 'Anggaran Pernikahan',
            'total_amount' => fake()->numberBetween(10000000, 100000000),
            'currency' => 'IDR',
            'status' => 'active',
        ];
    }
}
