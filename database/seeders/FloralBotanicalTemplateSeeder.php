<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FloralBotanicalTemplateSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the Floral Botanical template into the database.
     */
    public function run(): void
    {
        $exists = Template::where('slug', 'floral-botanical')->exists();

        if ($exists) {
            $this->command->info('Template "Floral Botanical" sudah ada, skip.');
            return;
        }

        Template::create([
            'name'      => 'Floral Botanical',
            'slug'      => 'floral-botanical',
            'thumbnail' => 'templates/floral-botanical-thumb.png',
            'preview'   => null,
            'sections'  => ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music'],
            'is_active' => true,
        ]);

        $this->command->info('Template "Floral Botanical" berhasil ditambahkan!');
    }
}
