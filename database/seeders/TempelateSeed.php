<?php

namespace Database\Seeders;

use App\Models\Music;
use App\Models\Template;
use Illuminate\Database\Seeder;
use Illuminate\Http\File as HttpFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            'thumb' => 'elegant-thumb.png',
            'preview' => 'simple_preview.png',
        ],
        [
            'name' => 'Luxe Amour',
            'slug' => 'luxe-amour',
            'thumb' => 'elegant-thumb.png',
            'preview' => 'elegant_preview.webp',
        ],
        [
            'name' => 'Elegant Classic',
            'slug' => 'elegant_tempelate',
            'thumb' => 'elegant-thumb.png',
            'preview' => 'simple_preview.png',
        ],
        [
            'name' => 'Anime Tempelate',
            'slug' => 'anime',
            'thumb' => 'elegant-thumb.png',
            'preview' => 'simple_preview.png',
        ],
        [
            'name' => 'Adat Tempelate',
            'slug' => 'adat',
            'thumb' => 'elegant-thumb.png',
            'preview' => 'simple_preview.png',
        ],
        [
            'name' => 'Element Tempelate',
            'slug' => 'element',
            'thumb' => 'elegant-thumb.png',
            'preview' => 'simple_preview.png',
        ],
        [
            'name' => 'Sample Tempelate',
            'slug' => 'sample',
            'thumb' => 'elegant-thumb.png',
            'preview' => 'simple_preview.png',
        ],
    ];


      foreach ($templates as $tpl) {

            $thumbSource   = public_path('tempelate/thumb/' . $tpl['thumb']);
            $previewSource = public_path('tempelate/preview/' . $tpl['preview']);

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
                    'name'       => $tpl['name'],
                    'thumbnail'  => $thumb,
                    'preview'    => $preview,
                    'sections'   => ["hero", "couple", "event", "gallery", "rsvp", "music"],
                    'is_active'  => true
                ]
            );
        }



    }
}
