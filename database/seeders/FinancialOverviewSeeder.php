<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\BudgetCategory;
use App\Models\Invitation;
use App\Models\SavingsContribution;
use App\Models\SavingsGoal;
use App\Models\VendorPayment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class FinancialOverviewSeeder extends Seeder
{
    public function run(): void
    {
        $invitation = Invitation::first();

        if (! $invitation) {
            return;
        }

        $user = $invitation->user;

        if (! $user) {
            return;
        }

        $budget = Budget::where('invitation_id', $invitation->id)->first();

        $savingsGoals = [
            [
                'name' => 'Dana Resepsi',
                'target_amount' => 75000000,
                'currency' => 'IDR',
                'deadline' => Carbon::parse($invitation->wedding_date)->subDays(30)->format('Y-m-d'),
                'colour' => '#0d9488',
                'description' => 'Tabungan khusus untuk biaya resepsi dan akad nikah.',
                'auto_savings_rule' => null,
                'is_active' => true,
                'is_shared' => true,
            ],
            [
                'name' => 'Honeymoon Bali',
                'target_amount' => 25000000,
                'currency' => 'IDR',
                'deadline' => Carbon::parse($invitation->wedding_date)->subDays(5)->format('Y-m-d'),
                'colour' => '#e11d48',
                'description' => 'Liburan bulan madu ke Bali.',
                'auto_savings_rule' => null,
                'is_active' => true,
                'is_shared' => true,
            ],
            [
                'name' => 'Dana Darurat',
                'target_amount' => 20000000,
                'currency' => 'IDR',
                'deadline' => Carbon::parse($invitation->wedding_date)->format('Y-m-d'),
                'colour' => '#d97706',
                'description' => 'Cadangan untuk keperluan mendesak.',
                'auto_savings_rule' => null,
                'is_active' => true,
                'is_shared' => false,
            ],
        ];

        foreach ($savingsGoals as $index => $goalData) {
            $goal = SavingsGoal::create(array_merge($goalData, [
                'invitation_id' => $invitation->id,
                'user_id' => $user->id,
            ]));

            $contributionCount = rand(3, 6);

            for ($i = 0; $i < $contributionCount; $i++) {
                SavingsContribution::create([
                    'savings_goal_id' => $goal->id,
                    'invitation_id' => $invitation->id,
                    'contributor_id' => $user->id,
                    'user_id' => $user->id,
                    'amount' => rand(500000, 5000000),
                    'currency' => 'IDR',
                    'method' => fake()->randomElement(['transfer', 'e-wallet', 'cash', 'card']),
                    'contributed_at' => fake()->dateTimeBetween('-90 days', 'now'),
                    'note' => fake()->sentence,
                    'is_automatic' => false,
                ]);
            }
        }

        if ($budget) {
            $categories = BudgetCategory::where('budget_id', $budget->id)->get();

            foreach ($categories->take(5) as $category) {
                VendorPayment::create([
                    'invitation_id' => $invitation->id,
                    'budget_category_id' => $category->id,
                    'user_id' => $user->id,
                    'vendor_name' => fake()->company(),
                    'vendor_contact' => fake()->phoneNumber(),
                    'amount' => fake()->numberBetween(2000000, 30000000),
                    'currency' => 'IDR',
                    'scheduled_date' => fake()->dateTimeBetween('-10 days', '+30 days')->format('Y-m-d'),
                    'due_date' => fake()->dateTimeBetween('+30 days', '+60 days')->format('Y-m-d'),
                    'paid_at' => fake()->boolean(50) ? Carbon::now() : null,
                    'status' => fake()->randomElement(['scheduled', 'paid', 'overdue', 'cancelled']),
                    'notes' => fake()->sentence,
                ]);
            }
        }
    }
}
