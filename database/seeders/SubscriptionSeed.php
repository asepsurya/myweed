<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubscriptionSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
   SubscriptionPlan::create([
            'name' => 'Basic Wedding',
            'slug' => 'basic',
            'price' => 0,
            'duration' => 2,
            'description' => json_encode([
                'Undangan Digital',
                '1 Tema Desain',
                'Dukungan Email',
            ]),
        ]);

        SubscriptionPlan::create([
            'name' => 'Pro Wedding',
            'slug' => 'pro',
            'price' => 99000,
            'duration' => 30,
            'description' => json_encode([
                'Semua Fitur Basic',
                '3 Tema Desain',
                'Laporan Kehadiran',
                'Gift Registry',
            ]),
        ]);

        SubscriptionPlan::create([
            'name' => 'Premium Wedding',
            'slug' => 'premium',
            'price' => 249000,
            'duration' => 30,
            'description' => json_encode([
                'Semua Fitur Pro',
                'Tema Desain Unlimited',
                'Laporan Kehadiran Lengkap',
                'Gift Registry Premium',
                'Custom Domain + SSL',
            ]),
        ]);
    }
}
