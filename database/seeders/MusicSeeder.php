<?php

namespace Database\Seeders;

use App\Models\Music;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
            $path = 'music/'.$filename;

            Storage::disk('public')->put($path, File::get($file));

            Music::updateOrCreate(
                ['audio_url' => $path],
                [
                    'title' => pathinfo($filename, PATHINFO_FILENAME),
                    'artist' => 'Wedding Music',
                    'audio_url' => $path,
                    'music_url' => $path,
                    'file_size' => $file->getSize(),
                    'mime_type' => File::mimeType($file->getPathname()),
                    'is_active' => true,
                ]
            );
        }

    }
}
