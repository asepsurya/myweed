<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Template;
use App\Models\TemplateType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TempelateSeed extends Seeder
{
    public function run(): void
    {
        $typeMap = TemplateType::pluck('id', 'slug')->all();
        $categoryMap = Category::pluck('id', 'slug')->all();

        $templates = [
            // Wedding (kategori utama, template yang sudah ada)
            ['name' => 'Simple', 'slug' => 'simple-theme', 'template_type_id' => $typeMap['basic'] ?? null, 'category_slug' => 'wedding', 'sections' => ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music']],
            ['name' => 'Luxe Amour', 'slug' => 'luxe-amour', 'template_type_id' => $typeMap['basic'] ?? null, 'category_slug' => 'wedding', 'sections' => ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music']],
            ['name' => 'Romantic Anime Dreams', 'slug' => 'romantic-anime', 'template_type_id' => $typeMap['luxury'] ?? null, 'category_slug' => 'wedding', 'sections' => ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music']],
            ['name' => 'Sweety Lovely', 'slug' => 'sweet-lovely', 'template_type_id' => $typeMap['premium'] ?? null, 'category_slug' => 'wedding', 'sections' => ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music']],
            ['name' => 'Black Gold', 'slug' => 'black-gold', 'template_type_id' => $typeMap['premium'] ?? null, 'category_slug' => 'wedding', 'sections' => ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music']],
            ['name' => 'Red Simple Elegant', 'slug' => 'red-simple-elegant', 'template_type_id' => $typeMap['luxury'] ?? null, 'category_slug' => 'wedding', 'sections' => ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music']],
            ['name' => 'Retro Magazine', 'slug' => 'retro-magazine', 'template_type_id' => $typeMap['luxury'] ?? null, 'category_slug' => 'wedding', 'sections' => ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music']],

            // Contoh template untuk setiap kategori lainnya
            ['name' => 'Engagement Elegant', 'slug' => 'engagement-elegant', 'template_type_id' => $typeMap['basic'] ?? null, 'category_slug' => 'engagement', 'sections' => ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music']],
            ['name' => 'Dino World Birthday', 'slug' => 'birthday-dino-world', 'template_type_id' => $typeMap['premium'] ?? null, 'category_slug' => 'birthday', 'sections' => ['hero', 'celebrant', 'event', 'gallery', 'rsvp', 'music']],
            ['name' => 'Tosca Baby Aqiqah', 'slug' => 'aqiqah-tosca-baby', 'template_type_id' => $typeMap['basic'] ?? null, 'category_slug' => 'aqiqah', 'sections' => ['hero', 'child', 'event', 'gallery', 'rsvp', 'music']],
            ['name' => 'Islamic Blue Khitan', 'slug' => 'khitan-islamic-blue', 'template_type_id' => $typeMap['basic'] ?? null, 'category_slug' => 'khitan', 'sections' => ['hero', 'child', 'event', 'gallery', 'rsvp', 'music']],
            ['name' => 'Graduation Excellence', 'slug' => 'graduation-excellence', 'template_type_id' => $typeMap['basic'] ?? null, 'category_slug' => 'graduation', 'sections' => ['hero', 'graduate', 'event', 'gallery', 'music']],
            ['name' => 'Professional Webinar', 'slug' => 'seminar-professional-webinar', 'template_type_id' => $typeMap['basic'] ?? null, 'category_slug' => 'seminar', 'sections' => ['hero', 'event', 'speaker', 'gallery', 'registration']],
            ['name' => 'Corporate Elite', 'slug' => 'corporate-elite', 'template_type_id' => $typeMap['luxury'] ?? null, 'category_slug' => 'corporate', 'sections' => ['hero', 'event', 'gallery', 'registration']],
            ['name' => 'Reunion Gathering', 'slug' => 'gathering-reunion', 'template_type_id' => $typeMap['basic'] ?? null, 'category_slug' => 'gathering', 'sections' => ['hero', 'event', 'gallery', 'rsvp', 'music']],
            ['name' => 'Grand Event', 'slug' => 'event-grand', 'template_type_id' => $typeMap['premium'] ?? null, 'category_slug' => 'event', 'sections' => ['hero', 'event', 'gallery', 'rsvp']],
            ['name' => 'Red Gold Christmas', 'slug' => 'christmas-red-gold', 'template_type_id' => $typeMap['premium'] ?? null, 'category_slug' => 'christmas', 'sections' => ['hero', 'event', 'gallery', 'rsvp', 'music']],
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
                    'id_category' => $categoryMap[$tpl['category_slug']] ?? null,
                    'sections' => $tpl['sections'] ?? ['hero', 'event', 'gallery'],
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
