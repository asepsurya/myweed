<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Template::create([
            'name' => 'Elegant Wedding',
            'slug' => 'elegant',
            'thumbnail' => 'elegant.png',
            'sections' => [
                'hero',
                'couple',
                'event',
                'gallery',
                'rsvp',
                'music'
            ]
        ]);
       Template::create([
            'name' => 'Love',
            'slug' => 'love',
            'thumbnail' => 'love.png',
            'sections' => [
                'hero',
                'couple',
                'event',
                'gallery',
                'rsvp',
                'music'
            ]
        ]);

    }
}
