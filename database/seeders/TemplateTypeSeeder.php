<?php

namespace Database\Seeders;

use App\Models\TemplateType;
use Illuminate\Database\Seeder;

class TemplateTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Basic', 'slug' => 'basic', 'color' => '#6c757d'],
            ['name' => 'Premium', 'slug' => 'premium', 'color' => '#0d6efd'],
            ['name' => 'Luxury', 'slug' => 'luxury', 'color' => '#D4AF37'],
        ];

        foreach ($types as $type) {
            TemplateType::updateOrCreate(['slug' => $type['slug']], $type);
        }
    }
}
