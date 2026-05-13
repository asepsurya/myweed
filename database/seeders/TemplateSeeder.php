<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music'];

        $templates = [
            // Wedding
            [
                'name' => 'Pastel Pink Delight',
                'slug' => 'pastel-pink-theme',
                'category' => 'Wedding',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Royal Blue Luxury',
                'slug' => 'royal-blue-theme',
                'category' => 'Wedding',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Forest Green Nature',
                'slug' => 'forest-green-theme',
                'category' => 'Wedding',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Lavender Dream',
                'slug' => 'lavender-theme',
                'category' => 'Wedding',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Minimalist Noir',
                'slug' => 'minimal-black-theme',
                'category' => 'Wedding',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Terracotta Earth',
                'slug' => 'terracotta-theme',
                'category' => 'Wedding',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Ocean Teal Refresh',
                'slug' => 'ocean-teal-theme',
                'category' => 'Wedding',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Vintage Sepia Classic',
                'slug' => 'vintage-sepia-theme',
                'category' => 'Wedding',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Berry Red Passion',
                'slug' => 'berry-red-theme',
                'category' => 'Wedding',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Classic Navy Elegant',
                'slug' => 'classic-navy-theme',
                'category' => 'Wedding',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            // New Categories
            [
                'name' => 'Tosca Baby Aqiqah',
                'slug' => 'aqiqah-theme',
                'category' => 'Aqiqah',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Islamic Blue Khitan',
                'slug' => 'khitan-theme',
                'category' => 'Khitan',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Dino World Birthday',
                'slug' => 'birthday-theme',
                'category' => 'Birthday',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Graduation Excellence',
                'slug' => 'graduation-theme',
                'category' => 'Graduation',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Tasyakuran Haji Mabrur',
                'slug' => 'tasyakuran-haji-theme',
                'category' => 'Syukuran',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Professional Webinar',
                'slug' => 'seminar-theme',
                'category' => 'Seminar',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Red Gold Christmas',
                'slug' => 'christmas-theme',
                'category' => 'Christmas',
                'thumbnail' => 'templates/x4GFEPCWMYgXu91Fik3OLBwlWW9LYA47ruBJsLvQ.png',
                'sections' => $sections,
                'is_active' => true,
            ],
            [
                'name' => 'Night Gala Party',
                'slug' => 'party-theme',
                'category' => 'Party',
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
