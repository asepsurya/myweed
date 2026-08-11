<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubscriptionPlan::create([
            'name' => 'Gratis',
            'slug' => 'gratis',
            'price' => 0,
            'duration' => 30,
            'description' => json_encode([
                '1 Tema Gratis',
                '50 Tamu undangan',
                'RSVP dasar',
                'Galeri foto 10 slot',
            ]),
            'is_free' => true,
        ]);

        SubscriptionPlan::create([
            'name' => 'Premium',
            'slug' => 'premium',
            'price' => 149000,
            'duration' => 30,
            'description' => json_encode([
                'Semua Tema Premium',
                'Unlimited tamu',
                'RSVP lengkap + analytics',
                'Galeri unlimited',
                'Hapus watermark',
            ]),
            'is_free' => false,
        ]);

        SubscriptionPlan::create([
            'name' => 'Exclusive',
            'slug' => 'exclusive',
            'price' => 499000,
            'duration' => 30,
            'description' => json_encode([
                'Semua fitur Premium',
                'Unlimited tamu',
                'RSVP + analytics lengkap',
                'Galeri unlimited',
                'Hapus watermark',
                'Custom domain + support 24/7',
            ]),
            'is_free' => false,
        ]);
    }
}
