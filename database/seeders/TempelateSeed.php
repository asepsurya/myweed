<?php

namespace Database\Seeders;

use App\Models\Template;
use App\Models\TemplateType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TempelateSeed extends Seeder
{
    public function run(): void
    {
        $typeMap = TemplateType::pluck('id', 'slug')->all();

        $templates = [
            ['name' => 'Simple', 'slug' => 'simple-theme', 'template_type_id' => $typeMap['basic'] ?? null],
            ['name' => 'Luxe Amour', 'slug' => 'luxe-amour', 'template_type_id' => $typeMap['basic'] ?? null],
            ['name' => 'Romantic Anime Dreams', 'slug' => 'romantic-anime', 'template_type_id' => $typeMap['luxury'] ?? null],
            ['name' => 'Sweety Lovely', 'slug' => 'sweet-lovely', 'template_type_id' => $typeMap['premium'] ?? null],
            ['name' => 'Black Gold', 'slug' => 'black-gold', 'template_type_id' => $typeMap['premium'] ?? null],
            ['name' => 'Red Simple Elegant', 'slug' => 'red-simple-elegant', 'template_type_id' => $typeMap['luxury'] ?? null],
            ['name' => 'Retro Magazine', 'slug' => 'retro-magazine', 'template_type_id' => $typeMap['luxury'] ?? null],
        ];

        foreach ($templates as $tpl) {
            $slug = $tpl['slug'];

            $thumb = $this->fetchFromR2("templates/{$slug}/thumb", 'templates', 'templates/placeholder.png');
            $preview = $this->fetchFromR2("templates/{$slug}/preview", 'preview', 'preview/placeholder.png');

            Template::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $tpl['name'],
                    'thumbnail' => $thumb,
                    'preview' => $preview,
                    'template_type_id' => $tpl['template_type_id'] ?? null,
                    'sections' => ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music'],
                    'is_active' => true,
                ]
            );
        }
    }

    private function fetchFromR2(string $r2Dir, string $localDiskFolder, string $placeholder): string
    {
        $r2 = Storage::disk('r2');

        try {
            if ($r2->exists($r2Dir)) {
                $files = $r2->listContents($r2Dir, false);
                foreach ($files as $file) {
                    if ($file['type'] === 'file') {
                        $path = method_exists($file, 'path') ? $file->path() : $file['path'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $filename = basename($path);

                        $localDir = storage_path("app/public/{$localDiskFolder}");
                        if (!file_exists($localDir)) {
                            mkdir($localDir, 0755, true);
                        }

                        $localPath = $localDir . '/' . $filename;

                        if (!file_exists($localPath)) {
                            $content = $r2->get($path);
                            file_put_contents($localPath, $content);
                        }

                        return "{$localDiskFolder}/{$filename}";
                    }
                }
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return $placeholder;
    }
}
