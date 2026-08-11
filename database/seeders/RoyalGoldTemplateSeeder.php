<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoyalGoldTemplateSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the Royal Gold template into the database.
     */
    public function run(): void
    {
        // Cek apakah template sudah ada agar tidak duplikat
        $exists = Template::where('slug', 'royal-gold')->exists();

        if ($exists) {
            $this->command->info('Template "Royal Gold" sudah ada, skip.');

            return;
        }

        Template::create([
            'name' => 'Royal Gold',
            'slug' => 'royal-gold',
            'thumbnail' => 'templates/royal-gold-thumb.png',  // Ganti dengan path thumbnail jika tersedia
            'preview' => null,                               // Ganti dengan path preview jika tersedia
            'sections' => ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music'],
            'is_active' => true,
        ]);

        $this->command->info('Template "Royal Gold" berhasil ditambahkan!');
    }
}
