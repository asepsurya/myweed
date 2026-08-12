<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\BudgetCategory;
use App\Models\BudgetExpense;
use App\Models\Invitation;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
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

        $budget = Budget::create([
            'invitation_id' => $invitation->id,
            'user_id' => $user->id,
            'title' => 'Anggaran Pernikahan 2026',
            'total_amount' => 150000000,
            'currency' => 'IDR',
            'status' => 'active',
        ]);

        $categories = [
            [
                'name' => 'Venue & Akad',
                'colour' => '#0d9488',
                'allocated_amount' => 45000000,
                'note' => 'Sewa gedung, tenda, dan perlengkapan akad',
                'sort_order' => 1,
            ],
            [
                'name' => 'Catering',
                'colour' => '#e11d48',
                'allocated_amount' => 50000000,
                'note' => 'Penyedia makanan dan minuman untuk tamu',
                'sort_order' => 2,
            ],
            [
                'name' => 'Dokumentasi',
                'colour' => '#7c3aed',
                'allocated_amount' => 25000000,
                'note' => 'Fotografer, videografer, dan editing',
                'sort_order' => 3,
            ],
            [
                'name' => 'Dekorasi',
                'colour' => '#d97706',
                'allocated_amount' => 20000000,
                'note' => 'Bunga, backdrop, lighting, dan dekorasi',
                'sort_order' => 4,
            ],
            [
                'name' => 'Gaun & Busana',
                'colour' => '#db2777',
                'allocated_amount' => 5000000,
                'note' => 'Gaun pengantin, jas, dan aksesoris',
                'sort_order' => 5,
            ],
            [
                'name' => 'Undangan',
                'colour' => '#059669',
                'allocated_amount' => 5000000,
                'note' => 'Cetak undangan, e-card, dan amplop',
                'sort_order' => 6,
            ],
            [
                'name' => 'Hiburan',
                'colour' => '#2563eb',
                'allocated_amount' => 30000000,
                'note' => 'Band, DJ, MC, dan hiburan acara',
                'sort_order' => 7,
            ],
            [
                'name' => 'Lainnya',
                'colour' => '#6c757d',
                'allocated_amount' => 5000000,
                'note' => 'Dana cadangan untuk keperluan tak terduga',
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $index => $categoryData) {
            $category = BudgetCategory::create(array_merge($categoryData, [
                'budget_id' => $budget->id,
            ]));

            $expenseCount = rand(1, 3);

            for ($i = 0; $i < $expenseCount; $i++) {
                BudgetExpense::create([
                    'budget_category_id' => $category->id,
                    'invitation_id' => $invitation->id,
                    'user_id' => $user->id,
                    'vendor_name' => fake()->company(),
                    'amount' => rand(500000, 10000000),
                    'expense_date' => fake()->date(),
                    'payment_method' => fake()->randomElement(['cash', 'transfer', 'e-wallet', 'credit', 'card']),
                    'description' => fake()->sentence,
                    'is_paid' => fake()->boolean(80),
                ]);
            }
        }
    }
}
