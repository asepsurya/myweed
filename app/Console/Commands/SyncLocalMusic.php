<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Music;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SyncLocalMusic extends Command
{
    protected $signature = 'music:sync-local
                            {--disk= : Disk to sync from (default: config music.disk)}
                            {--all : Include all files, not only mp3}
                            {--force : Overwrite existing records}';

    protected $description = 'Sync music files from local/public disk to music table';

    public function handle(): int
    {
        $disk = $this->option('disk') ?? config('music.disk', 'public');
        $onlyMp3 = !$this->option('all');
        $force = $this->option('force');

        $this->info("Syncing music from disk: {$disk}");
        $this->newLine();

        try {
            $files = collect(Storage::disk($disk)->files(''))
                ->filter(function ($path) use ($onlyMp3) {
                    if ($onlyMp3) {
                        return Str::endsWith($path, ['mp3', 'wav', 'ogg', 'm4a']);
                    }

                    return true;
                })
                ->values();
        } catch (\Throwable $e) {
            $this->error("Unable to list files from disk [{$disk}]: " . $e->getMessage());
            return self::FAILURE;
        }

        if ($files->isEmpty()) {
            $this->warn("No files found on disk [{$disk}].");
            return self::SUCCESS;
        }

        $this->info("Found {$files->count()} files.");
        $this->newLine();

        $bar = $this->output->createProgressBar($files->count());
        $bar->start();

        $created = 0;
        $skipped = 0;
        $updated = 0;

        foreach ($files as $path) {
            $filename = basename($path);
            $url = Storage::disk($disk)->url($path);

            $existing = Music::where('audio_url', $path)
                ->orWhere('music_url', $path)
                ->first();

            if ($existing) {
                if ($force) {
                    $existing->audio_url = $path;
                    $existing->music_url = $path;
                    $existing->save();
                    $updated++;
                } else {
                    $skipped++;
                    $bar->advance();
                    continue;
                }
            } else {
                Music::create([
                    'title'     => pathinfo($filename, PATHINFO_FILENAME),
                    'artist'    => 'Unknown Artist',
                    'audio_url' => $path,
                    'music_url' => $path,
                    'file_size' => Storage::disk($disk)->size($path) ?? null,
                    'mime_type' => Storage::disk($disk)->mimeType($path) ?? null,
                    'is_active' => true,
                ]);
                $created++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Sync completed:");
        $this->line("  Created : {$created}");
        $this->line("  Updated : {$updated}");
        $this->line("  Skipped : {$skipped}");

        return self::SUCCESS;
    }
}
