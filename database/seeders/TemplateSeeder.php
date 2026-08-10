<?php

namespace Database\Seeders;

use App\Models\Template;
use App\Models\Category;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $sections = ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music'];

        $categoryMap = Category::pluck('id', 'name')->all();

        $templates = [
            // Wedding
            [
                'name' => 'Pastel Pink Delight',
                'slug' => 'pastel-pink-theme',
                'id_category' => $categoryMap['Wedding'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Royal Blue Luxury',
                'slug' => 'royal-blue-theme',
                'id_category' => $categoryMap['Wedding'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Forest Green Nature',
                'slug' => 'forest-green-theme',
                'id_category' => $categoryMap['Wedding'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Lavender Dream',
                'slug' => 'lavender-theme',
                'id_category' => $categoryMap['Wedding'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Minimalist Noir',
                'slug' => 'minimal-black-theme',
                'id_category' => $categoryMap['Wedding'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Terracotta Earth',
                'slug' => 'terracotta-theme',
                'id_category' => $categoryMap['Wedding'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Ocean Teal Refresh',
                'slug' => 'ocean-teal-theme',
                'id_category' => $categoryMap['Wedding'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Vintage Sepia Classic',
                'slug' => 'vintage-sepia-theme',
                'id_category' => $categoryMap['Wedding'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Berry Red Passion',
                'slug' => 'berry-red-theme',
                'id_category' => $categoryMap['Wedding'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Classic Navy Elegant',
                'slug' => 'classic-navy-theme',
                'id_category' => $categoryMap['Wedding'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            // New Categories
            [
                'name' => 'Tosca Baby Aqiqah',
                'slug' => 'aqiqah-theme',
                'id_category' => $categoryMap['Aqiqah'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Islamic Blue Khitan',
                'slug' => 'khitan-theme',
                'id_category' => $categoryMap['Khitan'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Dino World Birthday',
                'slug' => 'birthday-theme',
                'id_category' => $categoryMap['Birthday'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Graduation Excellence',
                'slug' => 'graduation-theme',
                'id_category' => $categoryMap['Graduation'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Tasyakuran Haji Mabrur',
                'slug' => 'tasyakuran-haji-theme',
                'id_category' => $categoryMap['Syukuran'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Professional Webinar',
                'slug' => 'seminar-theme',
                'id_category' => $categoryMap['Seminar'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Red Gold Christmas',
                'slug' => 'christmas-theme',
                'id_category' => $categoryMap['Christmas'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Night Gala Party',
                'slug' => 'party-theme',
                'id_category' => $categoryMap['Party'] ?? null,
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            Template::updateOrCreate(['slug' => $template['slug']], $template);
        }
    }
}
