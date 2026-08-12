<?php

namespace Database\Factories;

use App\Models\Budget;
use App\Models\BudgetCategory;
use App\Models\BudgetExpense;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetExpenseFactory extends Factory
{
    protected $model = BudgetExpense::class;

    public function definition(): array
    {
        $category = BudgetCategory::factory()->create([
            'budget_id' => Budget::factory()->create([
                'invitation_id' => Invitation::factory(),
                'user_id' => User::factory(),
            ]),
        ]);

        return [
            'budget_category_id' => $category->id,
            'invitation_id' => $category->budget->invitation_id,
            'user_id' => $category->budget->user_id,
            'vendor_name' => fake()->company(),
            'amount' => fake()->numberBetween(500000, 10000000),
            'expense_date' => fake()->date(),
            'payment_method' => fake()->randomElement(['cash', 'transfer', 'e-wallet', 'credit', 'card']),
            'description' => fake()->sentence,
            'is_paid' => fake()->boolean(80),
        ];
    }
}
