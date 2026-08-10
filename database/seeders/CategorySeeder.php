<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Wedding', 'slug' => 'wedding', 'icon' => 'bi-heart'],
            ['name' => 'Aqiqah', 'slug' => 'aqiqah', 'icon' => 'bi-baby'],
            ['name' => 'Khitan', 'slug' => 'khitan', 'icon' => 'bi-scissors'],
            ['name' => 'Birthday', 'slug' => 'birthday', 'icon' => 'bi-cake'],
            ['name' => 'Graduation', 'slug' => 'graduation', 'icon' => 'bi-mortarboard'],
            ['name' => 'Syukuran', 'slug' => 'syukuran', 'icon' => 'bi-house-heart'],
            ['name' => 'Seminar', 'slug' => 'seminar', 'icon' => 'bi-people'],
            ['name' => 'Christmas', 'slug' => 'christmas', 'icon' => 'bi-tree'],
            ['name' => 'Party', 'slug' => 'party', 'icon' => 'bi-music-note-beamed'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
