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


        $thumbSource   = public_path('tempelate/sample_preview.png');
        $previewSource = public_path('tempelate/sample_preview.png');

        // simpan ke storage/app/public
        $thumb = Storage::disk('public')->putFile(
            'templates',
            new HttpFile($thumbSource)
        );

        $preview = Storage::disk('public')->putFile(
            'preview',
            new HttpFile($previewSource)
        );

        // hasil $thumb & $preview SAMA seperti upload
        // contoh: templates/abc123.png, preview/xyz456.png

        Template::create([
            'name'       => 'Simple',
            'slug'       => 'simple-theme',
            'thumbnail'  => $thumb,
            'preview'    => $preview,
            'sections'   => ["hero", "couple", "event", "gallery", "rsvp", "music"],
            'is_active'  => true
        ]);

        Template::create([
            'name'       => 'Ellegant Tempelate',
            'slug'       => 'elegant-theme',
            'thumbnail'  => $thumb,
            'preview'    => $preview,
            'sections'   => ["hero", "couple", "event", "gallery", "rsvp", "music"],
            'is_active'  => true
        ]);
        Template::create([
            'name'       => 'Anime Tempelate',
            'slug'       => 'anime',
            'thumbnail'  => $thumb,
            'preview'    => $preview,
            'sections'   => ["hero", "couple", "event", "gallery", "rsvp", "music"],
            'is_active'  => true
        ]);
        Template::create([
            'name'       => 'Adat Tempelate',
            'slug'       => 'adat',
            'thumbnail'  => $thumb,
            'preview'    => $preview,
            'sections'   => ["hero", "couple", "event", "gallery", "rsvp", "music"],
            'is_active'  => true
        ]);
        Template::create([
            'name'       => 'Element Tempelate',
            'slug'       => 'element',
            'thumbnail'  => $thumb,
            'preview'    => $preview,
            'sections'   => ["hero", "couple", "event", "gallery", "rsvp", "music"],
            'is_active'  => true
        ]);
        Template::create([
            'name'       => 'Sample Tempelate',
            'slug'       => 'sample',
            'thumbnail'  => $thumb,
            'preview'    => $preview,
            'sections'   => ["hero", "couple", "event", "gallery", "rsvp", "music"],
            'is_active'  => true
        ]);



    }
}
