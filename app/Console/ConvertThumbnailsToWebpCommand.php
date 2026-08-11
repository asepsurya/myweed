<?php

namespace App\Console\Commands;

use App\Models\Template;
use Illuminate\Console\Command;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;

class ConvertThumbnailsToWebpCommand extends Command
{
    protected $signature = 'thumbnails:convert-to-webp';

    protected $description = 'Convert existing template thumbnails from PNG/JPG to optimized WebP';

    public function handle(): int
    {
        $driver = new GdDriver;
        $manager = new ImageManager($driver);

        $templates = Template::whereNotNull('thumbnail')->get();
        $bar = $this->output->createProgressBar(count($templates));
        $bar->start();

        $converted = 0;
        $skipped = 0;
        $errors = 0;

        foreach ($templates as $template) {
            $thumbPath = $template->thumbnail;
            $fullPath = storage_path('app/public/'.$thumbPath);

            if (! file_exists($fullPath)) {
                $skipped++;
                $bar->advance();

                continue;
            }

            $webpPath = preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $thumbPath);
            $webpFullPath = storage_path('app/public/'.$webpPath);

            if (file_exists($webpFullPath)) {
                $skipped++;
                $bar->advance();

                continue;
            }

            try {
                $image = $manager->read($fullPath);

                if ($image->width() > 600) {
                    $image->scale(width: 600);
                }

                $image->save($webpFullPath, 75, 'webp');

                $template->update(['thumbnail' => $webpPath]);
                $converted++;
            } catch (\Throwable $e) {
                $this->error("Failed to convert {$thumbPath}: ".$e->getMessage());
                $errors++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info('Conversion complete.');
        $this->info("Converted: {$converted}");
        $this->info("Skipped: {$skipped}");
        $this->info("Errors: {$errors}");

        return self::SUCCESS;
    }
}
