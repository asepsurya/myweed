<?php

namespace Database\Factories;

use App\Models\Budget;
use App\Models\BudgetCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetCategoryFactory extends Factory
{
    protected $model = BudgetCategory::class;

    public function definition(): array
    {
        return [
            'budget_id' => Budget::factory(),
            'name' => fake()->randomElement(['Venue', 'Catering', 'Dress', 'Dokumentasi', 'Tamu', 'Dekorasi']),
            'colour' => fake()->hexColor(),
            'allocated_amount' => fake()->numberBetween(1000000, 50000000),
            'note' => fake()->sentence,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
