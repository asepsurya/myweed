<?php

namespace Database\Seeders;

use App\Models\Music;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MusicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $sourceDir = public_path('tempelate/music');
        $destinationDir = 'music';

        // pastikan folder tujuan ada
        Storage::disk('public')->makeDirectory($destinationDir);

        // ambil semua file audio
        $files = File::files($sourceDir);

       foreach ($files as $file) {
            $filename = $file->getFilename();
            $path = 'music/' . $filename;

            if (Music::where('audio_url', $path)->exists()) {
                continue;
            }

            Storage::disk('public')->put($path, File::get($file));

            Music::create([
                'title'     => pathinfo($filename, PATHINFO_FILENAME),
                'artist'    => 'Wedding Music',
                'audio_url' => $path,
                'duration'  => 'Auto',
                'category'  => 'Wedding',
                'mood'      => 'Romantic'
            ]);
        }

    }
}
