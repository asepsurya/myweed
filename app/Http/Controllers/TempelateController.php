<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Music;
use App\Models\Template;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class TempelateController extends Controller
{
    public function index(Request $request)
    {
      $tempelate = Template::all();
       $musics = Music::where('is_active', true)->get();
      return view('dashboard.tempelate.index', compact('tempelate','musics'));
    }
     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'thumbnail' => 'required|image',
            'preview' => 'required|image',
            'zip' => 'required|mimes:zip'
        ]);

        $folderName = Str::slug($request->name);
        $extractPath = resource_path("views/templates/$folderName");

        if (!file_exists($extractPath)) {
            mkdir($extractPath, 0755, true);
        }

        $file = $request->file('zip');
        $zipPath = $file->getRealPath();

        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive;
            if ($zip->open($zipPath) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();
            } else {
                return back()->with('error', 'File ZIP tidak valid atau rusak.');
            }
        } elseif (function_exists('exec')) {
            $escapedZip = escapeshellarg($zipPath);
            $escapedDest = escapeshellarg($extractPath);
            exec("unzip $escapedZip -d $escapedDest 2>&1", $output, $returnVar);
            if ($returnVar !== 0) {
                $powerShellCmd = "Expand-Archive -LiteralPath $escapedZip -DestinationPath $escapedDest -Force";
                exec("powershell -Command " . escapeshellarg($powerShellCmd) . " 2>&1", $psOutput, $psReturn);
                if ($psReturn !== 0) {
                    return back()->with('error', 'Gagal mengekstrak ZIP. Pastikan server mendukung ZipArchive, perintah unzip, atau PowerShell Expand-Archive.');
                }
            }
        } else {
            return back()->with('error', 'Server tidak mendukung ekstraksi ZIP. Aktifkan ekstensi php-zip atau pastikan perintah unzip/Expand-Archive tersedia.');
        }

        $thumb = $this->convertImageToWebp($request->file('thumbnail'), 'templates');
        $preview = $this->convertImageToWebp($request->file('preview'), 'preview');

        Template::create([
            'name' => $request->name,
            'slug' => $folderName,
            'thumbnail' => $thumb,
            'preview' => $preview,
            'sections' => ["hero","couple","event","gallery","rsvp","music"],
            'is_active' => true
        ]);

        return back()->with('success', 'Template berhasil diupload & diekstrak ke views/templates!');
    }

    public function importCode(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:templates,slug',
            'code' => 'required|string',
        ]);

        $slug = Str::slug($request->slug);
        $folderPath = resource_path("views/templates/$slug");

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        file_put_contents($folderPath . '/index.blade.php', $request->code);

        $thumb = $this->generatePlaceholderImage($slug, 'templates');
        $preview = $this->generatePlaceholderImage($slug, 'preview');

        Template::create([
            'name' => $request->name,
            'slug' => $slug,
            'thumbnail' => $thumb,
            'preview' => $preview,
            'sections' => ["hero","couple","event","gallery","rsvp","music"],
            'is_active' => true,
        ]);

        return back()->with('success', 'Template berhasil di-import dari code!');
    }

    private function generatePlaceholderImage($slug, $folder)
    {
        $dir = storage_path("app/public/$folder");
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = $slug . '-placeholder.png';
        $path = $dir . '/' . $filename;

        if (!file_exists($path)) {
            $img = imagecreatetruecolor(400, 300);
            $bg = imagecolorallocate($img, 120, 120, 120);
            imagefill($img, 0, 0, $bg);
            $textColor = imagecolorallocate($img, 255, 255, 255);
            imagestring($img, 5, 140, 140, $slug, $textColor);
            imagepng($img, $path);
            imagedestroy($img);
        }

        return $folder . '/' . $filename;
    }

     private function convertImageToWebp($file, $folder)
     {
         $tempSource = str_replace('\\', '/', sys_get_temp_dir() . '/' . uniqid() . '_' . $file->getClientOriginalName());
         $file->move(sys_get_temp_dir(), basename($tempSource));

         $destinationPath = str_replace('\\', '/', storage_path('app/public/' . $folder));
         if (!file_exists($destinationPath)) {
             mkdir($destinationPath, 0755, true);
         }

         $destFile = $destinationPath . '/' . uniqid() . '.webp';

         $driver = new \Intervention\Image\Drivers\Gd\Driver();
         $manager = new \Intervention\Image\ImageManager($driver);
         $image = $manager->read($tempSource);
         $image->save($destFile, 75, 'webp');

         @unlink($tempSource);

         return $folder . '/' . basename($destFile);
     }
    public function destroy(Template $template)
    {
        // Hapus folder template di views/templates
        $folderPath = resource_path("views/templates/{$template->slug}");

        if (File::exists($folderPath)) {
            File::deleteDirectory($folderPath);
        }

        // Hapus thumbnail
        if ($template->thumbnail && File::exists(public_path("storage/{$template->thumbnail}"))) {
            File::delete(public_path("storage/{$template->thumbnail}"));
        }

        // Hapus data DB
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

        if (!$invitation) {
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
                'enable_gift' => false,
            ]);
        }

        $template = Template::findOrFail($id);
        $template->increment('views_count');

        if (auth()->check() && $invitation->template_id != $template->id) {
            $invitation->update([
                'template_id' => $template->id
            ]);
            $invitation->load('template');
        } else {
            // Jika guest, kita "set" saja secara temporary di object agar bisa di-preview tanpa simpan ke DB
            $invitation->setRelation('template', $template);
        }

        $themeColor = $request->query('theme_color', '#3b82f6');

        $templateView = 'templates.' . $invitation->template->slug . '.index';

        if (!view()->exists($templateView)) {
            abort(404, 'Template tidak ditemukan');
        }

        return view($templateView, compact('invitation', 'themeColor'));
    }

    public function previewUpdate($slug, $id, Request $request)
    {
        $invitation = Invitation::where('slug', $slug)->first();

        if ($invitation) {
            $updateableFields = [
                'groom_name', 'groom_nickname', 'groom_father_name', 'groom_mother_name',
                'groom_username_instagram',
                'bride_name', 'bride_nickname', 'bride_father_name', 'bride_mother_name',
                'bride_username_instagram',
                'wedding_date', 'akad_location', 'akad_time', 'akad_time_end',
                'akad_maps', 'akad_address', 'resepsi_location', 'resepsi_time',
                'resepsi_time_end', 'resepsi_maps', 'resepsi_address',
                'theme_color', 'wedding_quote', 'quote_id', 'video_link',
                'enable_rsvp', 'enable_gift', 'enable_music',
                'rsvp_deadline', 'rsvp_message', 'rsvp_whatsapp',
                'music_youtube_url',
            ];

            $data = $request->only($updateableFields);

            // Filter out empty strings to prevent overwriting existing demo data
            $data = array_filter($data, function($value) {
                return $value !== null && $value !== '';
            });
            foreach ($data as $key => $value) {
                if ($value === null) unset($data[$key]);
            }

            if ($request->has('enable_rsvp')) $data['enable_rsvp'] = $request->boolean('enable_rsvp');
            if ($request->has('enable_gift')) $data['enable_gift'] = $request->boolean('enable_gift');
            if ($request->has('enable_music')) $data['enable_music'] = $request->boolean('enable_music');

            if ($request->filled('music_youtube_url')) {
                $data['music_youtube_url'] = $request->music_youtube_url;
            }

            if (!empty($data['groom_username_instagram'])) {
                $data['groom_instagram'] = 'https://www.instagram.com/' . $data['groom_username_instagram'];
            }
            if (!empty($data['bride_username_instagram'])) {
                $data['bride_instagram'] = 'https://www.instagram.com/' . $data['bride_username_instagram'];
            }

            $invitation->update($data);
        }

        $themeColor = $request->input('theme_color', $invitation ? ($invitation->theme_color ?? '#FF6B81') : '#FF6B81');
        $baseUrl = '/templates/' . $slug . '/' . $id;

        return response()->json([
            'preview_url' => $baseUrl . '?theme_color=' . urlencode($themeColor) . '&t=' . time(),
        ]);
    }

    public function demo($slug)
    {
        // Ambil template berdasarkan slug
        $template = Template::where('slug', $slug)->firstOrFail();

        // Increment view count
        $template->increment('views_count');

        // Cari invitation contoh (paling baru)
        $invitation = Invitation::with(['template', 'galleries', 'rsvps'])->latest()->first();

        if (!$invitation) {
            // Create a mock invitation in memory
            $invitation = new Invitation([
                'slug' => 'demo-wedding',
                'groom_name' => 'Romeo',
                'bride_name' => 'Juliet',
                'event_date' => now()->addMonths(3),
                'event_location' => 'Gedung Serbaguna, Jakarta',
            ]);
            $invitation->id = 0; // Temporary ID
        }

        // Set template secara temporary untuk preview
        $invitation->setRelation('template', $template);

        $templateView = 'templates.' . $template->slug . '.index';

        if (!view()->exists($templateView)) {
            abort(404, 'File template tidak ditemukan');
        }

        return view($templateView, compact('invitation'));
    }

    public function liveUpdate(Request $request)
    {
        $templateId = $request->template_id;
        if (!$templateId) {
            return "Pilih template terlebih dahulu";
        }

        $template = Template::findOrFail($templateId);
        
        // Create a mock invitation object
        $invitation = new Invitation($request->all());
        $invitation->id = $request->id ?? 0; // Use existing ID or dummy 0 for preview
        $invitation->setRelation('template', $template);
        
        // Mock relationships
        $invitation->setRelation('galleries', collect([]));
        $invitation->setRelation('rsvps', collect([]));
        
        $templateView = 'templates.' . $template->slug . '.index';
        
        if (!view()->exists($templateView)) {
            return "Template view not found: " . $templateView;
        }

        $html = view($templateView, compact('invitation'))->render();
        
        // Inject script for live image synchronization
        $previewData = json_encode([
            'pria' => $request->preview_foto_pria,
            'wanita' => $request->preview_foto_wanita,
            'cover' => $request->preview_gallery_cover,
            'gallery' => $request->preview_gallery // This should be an array of base64/blob
        ]);

        $syncScript = "
        <script>
            (function() {
                const images = " . $previewData . ";
                const sync = (data) => {
                    const imgs = data || images;
                    // Groom & Bride
                    if (imgs.pria) {
                        document.querySelectorAll('img[src*=\"foto_pria\"], img[alt*=\"Groom\"], .groom-photo img, .couple-img[alt=\"Groom\"]').forEach(i => i.src = imgs.pria);
                    }
                    if (imgs.wanita) {
                        document.querySelectorAll('img[src*=\"foto_wanita\"], img[alt*=\"Bride\"], .bride-photo img, .couple-img[alt=\"Bride\"]').forEach(i => i.src = imgs.wanita);
                    }
                    // Hero/Cover
                    if (imgs.cover) {
                         document.querySelectorAll('*').forEach(el => {
                            const style = window.getComputedStyle(el);
                            if (style.backgroundImage && (style.backgroundImage.includes('gallery_cover') || el.classList.contains('hero') || el.classList.contains('cover'))) {
                                el.style.backgroundImage = 'url(' + imgs.cover + ')';
                            }
                         });
                    }
                    // Gallery
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

        return $html . $syncScript;
    }

    public function like(Template $template)
    {
        $template->increment('likes_count');
        return response()->json([
            'success' => true,
            'likes_count' => $template->likes_count
        ]);
    }
}
