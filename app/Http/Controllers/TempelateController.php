<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Invitation;
use App\Models\Music;
use App\Models\Template;
use App\View\TemplateViewFinder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use ZipArchive;

class TempelateController extends Controller
{
    public function index(Request $request)
    {
        $tempelate = Template::with(['category', 'templateType'])->get();
        $musics = Music::where('is_active', true)->get();
        $categories = Category::orderBy('name')->get();
        $templateTypes = \App\Models\TemplateType::orderBy('name')->get();

        return view('dashboard.tempelate.index', compact('tempelate', 'musics', 'categories', 'templateTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'thumbnail' => 'required|image',
            'zip' => 'required|mimes:zip',
            'id_category' => 'required|exists:categories,id',
            'template_type_id' => 'nullable|exists:template_types,id',
        ]);

        $folderName = Str::slug($request->name);
        $tempPath = sys_get_temp_dir() . '/template_upload_' . uniqid();

        if (! file_exists($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        $file = $request->file('zip');
        $zipPath = $file->getRealPath();

        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive;
            if ($zip->open($zipPath) === true) {
                $zip->extractTo($tempPath);
                $zip->close();
            } else {
                return back()->with('error', 'File ZIP tidak valid atau rusak.');
            }
        } elseif (function_exists('exec')) {
            $escapedZip = escapeshellarg($zipPath);
            $escapedDest = escapeshellarg($tempPath);
            exec("unzip $escapedZip -d $escapedDest 2>&1", $output, $returnVar);
            if ($returnVar !== 0) {
                $powerShellCmd = "Expand-Archive -LiteralPath $escapedZip -DestinationPath $escapedDest -Force";
                exec('powershell -Command '.escapeshellarg($powerShellCmd).' 2>&1', $psOutput, $psReturn);
                if ($psReturn !== 0) {
                    return back()->with('error', 'Gagal mengekstrak ZIP. Pastikan server mendukung ZipArchive, perintah unzip, atau PowerShell Expand-Archive.');
                }
            }
        } else {
            return back()->with('error', 'Server tidak mendukung ekstraksi ZIP. Aktifkan ekstensi php-zip atau pastikan perintah unzip/Expand-Archive tersedia.');
        }

        $this->uploadTemplateDirectoryToR2($tempPath, $folderName);

        $thumbFromZip = $this->findThumbnailInDirectory($tempPath);
        if ($thumbFromZip) {
            $r2ThumbPath = 'templates/'.$folderName.'/thumb/'.basename($thumbFromZip);
            Storage::disk('r2')->put($r2ThumbPath, file_get_contents($thumbFromZip));
            $thumb = $r2ThumbPath;
        } else {
            $thumb = $this->convertImageToWebp($request->file('thumbnail'), 'templates');
        }

        $preview = $this->convertImageToWebp($request->file('preview'), 'preview');

        $this->deleteDirectoryRecursive($tempPath);

        Template::create([
            'name' => $request->name,
            'slug' => $folderName,
            'thumbnail' => $thumb,
            'preview' => $preview,
            'id_category' => $request->id_category,
            'template_type_id' => $request->template_type_id,
            'sections' => ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music'],
            'is_active' => true,
        ]);

        return redirect()->route('tempelate.index')->with('success', 'Template berhasil diupload & disimpan ke R2!');
    }

    public function importCode(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:templates,slug',
            'code' => 'required|string',
            'id_category' => 'required|exists:categories,id',
            'template_type_id' => 'nullable|exists:template_types,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $slug = Str::slug($request->slug);
        $r2Path = "templates/{$slug}/index.blade.php";

        Storage::disk('r2')->put($r2Path, $request->code);

        /** @var TemplateViewFinder $finder */
        $finder = app('view.finder');
        $finder->clearCache($slug);

        if ($request->hasFile('thumbnail')) {
            $thumb = $this->convertImageToWebp($request->file('thumbnail'), 'templates');
        } else {
            $thumb = $this->generatePlaceholderImage($slug, 'templates');
        }
        $preview = $this->generatePlaceholderImage($slug, 'preview');

        Template::create([
            'name' => $request->name,
            'slug' => $slug,
            'thumbnail' => $thumb,
            'preview' => $preview,
            'id_category' => $request->id_category,
            'template_type_id' => $request->template_type_id,
            'sections' => ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music'],
            'is_active' => true,
        ]);

        return redirect()->route('tempelate.index')->with('success', 'Template berhasil di-import dari code!');
    }

    private function generatePlaceholderImage($slug, $folder)
    {
        $dir = storage_path("app/public/$folder");
        if (! file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = $slug.'-placeholder.png';
        $path = $dir.'/'.$filename;

        if (! file_exists($path)) {
            $img = imagecreatetruecolor(400, 300);
            $bg = imagecolorallocate($img, 120, 120, 120);
            imagefill($img, 0, 0, $bg);
            $textColor = imagecolorallocate($img, 255, 255, 255);
            imagestring($img, 5, 140, 140, $slug, $textColor);
            imagepng($img, $path);
            imagedestroy($img);
        }

        return $folder.'/'.$filename;
    }

    private function convertImageToWebp($file, $folder)
    {
        $tempSource = str_replace('\\', '/', sys_get_temp_dir().'/'.uniqid().'_'.$file->getClientOriginalName());
        $file->move(sys_get_temp_dir(), basename($tempSource));

        $destinationPath = str_replace('\\', '/', storage_path('app/public/'.$folder));
        if (! file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $destFile = $destinationPath.'/'.uniqid().'.webp';

        $driver = new Driver;
        $manager = new ImageManager($driver);
        $image = $manager->read($tempSource);
        $image->save($destFile, 75, 'webp');

        @unlink($tempSource);

        return $folder.'/'.basename($destFile);
    }

    public function destroy(Template $template)
    {
        Storage::disk('r2')->deleteDirectory("templates/{$template->slug}");

        /** @var TemplateViewFinder $finder */
        $finder = app('view.finder');
        $finder->clearCache($template->slug);

        if ($template->thumbnail && File::exists(public_path("storage/{$template->thumbnail}"))) {
            File::delete(public_path("storage/{$template->thumbnail}"));
        }

        $template->delete();

        return back()->with('success', 'Template berhasil dihapus.');
    }

    public function preview($slug, $id, Request $request)
    {
        $invitation = Invitation::with([
            'template',
            'galleries',
            'rsvps',
        ])
            ->where('slug', $slug)
            ->first();

        if (! $invitation) {
            try {
                $invitation = Invitation::create([
                    'user_id' => 1,
                    'template_id' => $id,
                    'slug' => $slug,
                    'is_default' => true,
                    'groom_name' => 'Romeo',
                    'groom_nickname' => 'Romeo',
                    'groom_father_name' => 'Tuan Montague',
                    'groom_mother_name' => 'Nyonya Montague',
                    'bride_name' => 'Juliet',
                    'bride_nickname' => 'Juliet',
                    'bride_father_name' => 'Tuan Capulet',
                    'bride_mother_name' => 'Nyonya Capulet',
                    'wedding_date' => date('Y-m-d'),
                    'enable_rsvp' => true,
                    'enable_gift' => true,
                    'enable_gallery' => true,
                    'enable_music' => true,
                    'enable_video' => true,
                    'enable_love_story' => true,
                ]);
            } catch (\Throwable $e) {
                \Log::error('Template preview create failed: ' . $e->getMessage());
                abort(500, 'Gagal memuat preview template.');
            }
        }

        $template = Template::findOrFail($id);
        $template->increment('views_count');

        if (auth()->check() && $invitation->template_id != $template->id) {
            $invitation->update([
                'template_id' => $template->id,
            ]);
            $invitation->load('template');
        } else {
            $invitation->setRelation('template', $template);
        }

        $themeColor = $request->query('theme_color', '#3b82f6');

        $templateView = 'templates.'.$invitation->template->slug.'.index';

        if (! view()->exists($templateView)) {
            abort(404, 'Template tidak ditemukan');
        }

        $seoTitle = "Template {$template->name} - Undangan Digital | RuangUndang";
        $seoDescription = $template->description ?? "Pratinjau template undangan digital '{$template->name}'. Desain elegan dan modern untuk pernikahan impian Anda. Lihat tampilan live dan gunakan untuk undangan Anda.";
        $seoKeywords = "template undangan, {$template->name}, undangan digital, template pernikahan, desain undangan";
        $seoImage = template_thumbnail_url($template, $template->updated_at->timestamp);

        $jsonLd = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => $template->name,
                'description' => $seoDescription,
                'image' => $seoImage,
                'url' => url()->current(),
                'category' => 'Template Undangan Digital',
                'offers' => [
                    '@type' => 'Offer',
                    'price' => '0',
                    'priceCurrency' => 'IDR',
                    'availability' => 'https://schema.org/InStock',
                ],
            ],
        ];

        view()->share('seoTitle', $seoTitle);
        view()->share('seoDescription', $seoDescription);
        view()->share('seoKeywords', $seoKeywords);
        view()->share('seoImage', $seoImage);
        view()->share('jsonLd', $jsonLd);

        return view($templateView, compact('invitation', 'themeColor'));
    }

    public function previewUpdate($slug, $id, Request $request)
    {
        $invitation = Invitation::where('slug', $slug)->first();

        if ($invitation) {
            $updateableFields = [
                'groom_name', 'groom_nickname', 'groom_father_name', 'groom_mother_name',
                'groom_child_order', 'groom_username_instagram',
                'bride_name', 'bride_nickname', 'bride_father_name', 'bride_mother_name',
                'bride_child_order', 'bride_username_instagram',
                'wedding_date', 'akad_location', 'akad_time', 'akad_time_end',
                'akad_maps', 'akad_address', 'resepsi_location', 'resepsi_time',
                'resepsi_time_end', 'resepsi_maps', 'resepsi_address',
                'theme_color', 'wedding_quote', 'quote_id', 'video_link',
                'enable_rsvp', 'enable_gift', 'enable_music', 'enable_gallery', 'enable_video', 'enable_love_story',
                'rsvp_deadline', 'rsvp_message', 'rsvp_whatsapp',
                'music_youtube_url',
            ];

            $data = $request->only($updateableFields);

            $data = array_filter($data, function ($value) {
                return $value !== null && $value !== '';
            });
            foreach ($data as $key => $value) {
                if ($value === null) {
                    unset($data[$key]);
                }
            }

            if ($request->has('enable_rsvp')) {
                $data['enable_rsvp'] = $request->boolean('enable_rsvp');
            }
            if ($request->has('enable_gift')) {
                $data['enable_gift'] = $request->boolean('enable_gift');
            }
            if ($request->has('enable_music')) {
                $data['enable_music'] = $request->boolean('enable_music');
            }
            if ($request->has('enable_gallery')) {
                $data['enable_gallery'] = $request->boolean('enable_gallery');
            }
            if ($request->has('enable_video')) {
                $data['enable_video'] = $request->boolean('enable_video');
            }
            if ($request->has('enable_love_story')) {
                $data['enable_love_story'] = $request->boolean('enable_love_story');
            }

            if ($request->filled('music_youtube_url')) {
                $data['music_youtube_url'] = $request->music_youtube_url;
            }

            if (! empty($data['groom_username_instagram'])) {
                $data['groom_instagram'] = 'https://www.instagram.com/'.$data['groom_username_instagram'];
            }
            if (! empty($data['bride_username_instagram'])) {
                $data['bride_instagram'] = 'https://www.instagram.com/'.$data['bride_username_instagram'];
            }

            $invitation->update($data);
        }

        $themeColor = $request->input('theme_color', $invitation ? ($invitation->theme_color ?? '#FF6B81') : '#FF6B81');
        $baseUrl = '/templates/'.$slug.'/'.$id;

        return response()->json([
            'preview_url' => $baseUrl.'?theme_color='.urlencode($themeColor).'&t='.time(),
        ]);
    }

    public function demo($slug)
    {
        $template = Template::where('slug', $slug)->firstOrFail();

        $template->increment('views_count');

        $invitation = Invitation::with(['template', 'galleries', 'rsvps'])->latest()->first();

        if (! $invitation) {
            $invitation = new Invitation([
                'slug' => 'demo-wedding',
                'groom_name' => 'Romeo',
                'bride_name' => 'Juliet',
                'event_date' => now()->addMonths(3),
                'event_location' => 'Gedung Serbaguna, Jakarta',
            ]);
            $invitation->id = 0;
        }

        $invitation->setRelation('template', $template);

        $templateView = 'templates.'.$template->slug.'.index';

        if (! view()->exists($templateView)) {
            abort(404, 'File template tidak ditemukan');
        }

        return view($templateView, compact('invitation'));
    }

    public function liveUpdate(Request $request)
    {
        $templateId = $request->template_id;
        if (! $templateId) {
            return 'Pilih template terlebih dahulu';
        }

        $template = Template::find($templateId);
        if (! $template) {
            return 'Pilih template terlebih dahulu';
        }

        $invitation = new Invitation($request->all());
        $invitation->id = $request->id ?? 0;
        $invitation->setRelation('template', $template);

        $invitation->setRelation('galleries', collect([]));
        $invitation->setRelation('rsvps', collect([]));

        $templateView = 'templates.'.$template->slug.'.index';

        if (! view()->exists($templateView)) {
            return 'Template view not found: '.$templateView;
        }

        try {
            $html = view($templateView, compact('invitation'))->render();
        } catch (\Throwable $e) {
            \Log::error('Live preview render failed: ' . $e->getMessage(), [
                'template' => $templateView,
                'exception' => $e,
            ]);

            return '<div style="padding:40px;text-align:center;font-family:sans-serif;">
                <h3 style="color:#dc3545;">Preview Error</h3>
                <p>Gagal memuat preview template. Coba lagi atau pilih template lain.</p>
                <pre style="background:#f8f9f5;padding:10px;border-radius:4px;text-align:left;font-size:12px;overflow:auto;">'.e($e->getMessage()).'</pre>
            </div>';
        }

        $previewData = json_encode([
            'pria' => $request->preview_foto_pria,
            'wanita' => $request->preview_foto_wanita,
            'cover' => $request->preview_gallery_cover,
            'gallery' => $request->preview_gallery,
        ]);

        $syncScript = '
        <script>
            (function() {
                const images = '.$previewData.";
                const sync = (data) => {
                    const imgs = data || images;
                    if (imgs.pria) {
                        document.querySelectorAll('img[src*=\"foto_pria\"], img[alt*=\"Groom\"], .groom-photo img, .couple-img[alt=\"Groom\"]').forEach(i => i.src = imgs.pria);
                    }
                    if (imgs.wanita) {
                        document.querySelectorAll('img[src*=\"foto_wanita\"], img[alt*=\"Bride\"], .bride-photo img, .couple-img[alt=\"Bride\"]').forEach(i => i.src = imgs.wanita);
                    }
                    if (imgs.cover) {
                         document.querySelectorAll('*').forEach(el => {
                            const style = window.getComputedStyle(el);
                            if (style.backgroundImage && (style.backgroundImage.includes('gallery_cover') || el.classList.contains('hero') || el.classList.contains('cover'))) {
                                el.style.backgroundImage = 'url(' + imgs.cover + ')';
                            }
                         });
                    }
                    if (imgs.gallery && imgs.gallery.length > 0) {
                        const galleryContainer = document.querySelector('.masonry-gallery');
                        if (galleryContainer) {
                            galleryContainer.innerHTML = imgs.gallery.map(src => `
                                <a href=\"\${src}\" data-fancybox=\"gallery\" class=\"masonry-item\">
                                    <img src=\"\${src}\" alt=\"Gallery\">
                                </a>
                            `).join('');
                        }
                    }
                };

                if (document.readyState === 'complete') sync();
                else window.addEventListener('load', () => sync());

                window.addEventListener('message', function(e) {
                    if (e.data.type === 'syncImages') {
                        sync(e.data.images);
                    }
                });
            })();
        </script>";

        return $html.$syncScript;
    }

    public function like(Template $template)
    {
        $template->increment('likes_count');

        return response()->json([
            'success' => true,
            'likes_count' => $template->likes_count,
        ]);
    }

    private function uploadTemplateDirectoryToR2(string $sourceDir, string $r2Prefix): void
    {
        $r2 = Storage::disk('r2');
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($sourceDir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $relativePath = str_replace($sourceDir . DIRECTORY_SEPARATOR, '', $file->getPathname());
                $r2Path = 'templates/' . $r2Prefix . '/' . str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);
                $content = file_get_contents($file->getPathname());
                $r2->put($r2Path, $content);
            }
        }
    }

    private function deleteDirectoryRecursive(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            is_dir($path) ? $this->deleteDirectoryRecursive($path) : unlink($path);
        }
        rmdir($dir);
    }

    private function findThumbnailInDirectory(string $dir): ?string
    {
        $thumbDir = $dir . DIRECTORY_SEPARATOR . 'thumb';

        if (! is_dir($thumbDir)) {
            return null;
        }

        $files = array_diff(scandir($thumbDir), ['.', '..']);

        foreach ($files as $file) {
            $path = $thumbDir . DIRECTORY_SEPARATOR . $file;
            if (is_file($path)) {
                return $path;
            }
        }

        return null;
    }

    public function sync(Request $request)
    {
        $r2 = Storage::disk('r2');
        $added = 0;
        $updated = 0;
        $errors = [];

        try {
            $items = $r2->listContents('templates', false);
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal membaca R2: '.$e->getMessage());
        }

        foreach ($items as $item) {
            if ($item['type'] !== 'dir') {
                continue;
            }

            $slug = $item['basename'] ?? basename($item['path']);
            $slug = Str::slug($slug);

            $template = Template::where('slug', $slug)->first();

            if (! $template) {
                $thumb = $this->syncThumbnailFromR2($r2, $slug);

                if (! $thumb) {
                    $thumb = $this->generatePlaceholderImage($slug, 'templates');
                }

                $data = [
                    'name' => Str::title(str_replace('-', ' ', $slug)),
                    'slug' => $slug,
                    'thumbnail' => $thumb,
                    'preview' => $thumb,
                    'sections' => ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music'],
                    'is_active' => true,
                ];

                $category = Category::inRandomOrder()->first();
                if ($category) {
                    $data['id_category'] = $category->id;
                }

                Template::create($data);

                $added++;
            } else {
                if (! $template->thumbnail) {
                    $thumb = $this->syncThumbnailFromR2($r2, $slug);
                    if ($thumb) {
                        $template->update(['thumbnail' => $thumb]);
                        $updated++;
                    }
                }
            }
        }

        $message = "Sinkronisasi selesai. {$added} template baru ditambahkan, {$updated} thumbnail diperbarui.";
        if (! empty($errors)) {
            $message .= ' ('.count($errors).' error)';
        }

        return back()->with('success', $message);
    }

    private function syncThumbnailFromR2($r2, string $slug): ?string
    {
        $thumbPath = "templates/{$slug}/thumb";

        try {
            $files = $r2->listContents($thumbPath, false);
            foreach ($files as $file) {
                if ($file['type'] === 'file') {
                    $path = method_exists($file, 'path') ? $file->path() : $file['path'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $localPath = storage_path('app/public/templates/'.$slug.'-thumb.'.$ext);

                    if (! file_exists($localPath)) {
                        $content = $r2->get($path);
                        file_put_contents($localPath, $content);
                    }

                    return 'templates/'.$slug.'-thumb.'.$ext;
                }
            }
        } catch (\Throwable $e) {
            // Ignore
        }

        return null;
    }

    public function editCode(Template $template)
    {
        $r2Path = "templates/{$template->slug}/index.blade.php";
        $code = '';

        try {
            if (Storage::disk('r2')->exists($r2Path)) {
                $code = Storage::disk('r2')->get($r2Path);
            }
        } catch (\Throwable $e) {
            $code = '';
        }

        $categories = \App\Models\Category::orderBy('name')->get(['id', 'name']);
        $templateTypes = \App\Models\TemplateType::orderBy('name')->get(['id', 'name', 'color', 'slug']);

        return response()->json([
            'success' => true,
            'template' => [
                'id' => $template->id,
                'name' => $template->name,
                'slug' => $template->slug,
                'category_id' => $template->id_category,
                'category' => $template->category->name ?? 'N/A',
                'template_type_id' => $template->template_type_id,
            ],
            'categories' => $categories,
            'template_types' => $templateTypes,
            'code' => $code,
        ]);
    }

    public function saveCode(Request $request, Template $template)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $r2Path = "templates/{$template->slug}/index.blade.php";

        Storage::disk('r2')->put($r2Path, $request->input('code'));

        /** @var \App\View\TemplateViewFinder $finder */
        $finder = app('view.finder');
        $finder->clearCache($template->slug);

        return response()->json([
            'success' => true,
            'message' => 'Template berhasil diperbarui di R2.',
        ]);
    }

    public function updateInfo(Request $request, Template $template)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'template_type_id' => 'nullable|exists:template_types,id',
        ]);

        $template->update([
            'name' => $request->name,
            'template_type_id' => $request->template_type_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Informasi template berhasil diperbarui.',
            'template' => [
                'id' => $template->id,
                'name' => $template->name,
                'slug' => $template->slug,
                'category_id' => $template->id_category,
                'category' => $template->category->name ?? 'N/A',
                'template_type_id' => $template->template_type_id,
                'template_type' => $template->templateType ? $template->templateType->name : null,
            ],
        ]);
    }
}
