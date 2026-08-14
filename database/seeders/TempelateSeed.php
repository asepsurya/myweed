<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;
use Illuminate\Http\File as HttpFile;
use Illuminate\Support\Facades\Storage;

class TempelateSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $templates = [
            [
                'name' => 'Simple',
                'slug' => 'simple-theme',
                'thumb' => 'simple-theme.png',
                'preview' => 'simple_preview.png',
            ],
            [
                'name' => 'Luxe Amour',
                'slug' => 'luxe-amour',
                'thumb' => 'elegant-thumb.png',
                'preview' => 'elegant_preview.webp',
            ],
        
            
            [
                'name' => 'Romantic Anime Dreams',
                'slug' => 'romantic-anime',
                'thumb' => 'romantic-anime.png',
                'preview' => 'elegant_preview.webp',
            ],
            [
                'name' => 'Sweety Lovely',
                'slug' => 'sweet-lovely',
                'thumb' => 'sweet-lovely.png',
                'preview' => 'elegant_preview.webp',
            ],

       
        ];

        foreach ($templates as $tpl) {

            $thumbSource = public_path('tempelate/thumb/'.$tpl['thumb']);
            $previewSource = public_path('tempelate/preview/'.$tpl['preview']);

            // Simpan thumbnail
            $thumb = Storage::disk('public')->putFile(
                'templates',
                new HttpFile($thumbSource)
            );

            // Simpan preview
            $preview = Storage::disk('public')->putFile(
                'preview',
                new HttpFile($previewSource)
            );

            Template::updateOrCreate(
                ['slug' => $tpl['slug']],
                [
                    'name' => $tpl['name'],
                    'thumbnail' => $thumb,
                    'preview' => $preview,
                    'sections' => ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music'],
                    'is_active' => true,
                ]
            );
        }

    }
}
