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

    $zip = new ZipArchive;
    $file = $request->file('zip');
    $zipPath = $file->getRealPath();

    if ($zip->open($zipPath) !== TRUE) {
        return back()->with('error', 'File ZIP tidak valid atau rusak.');
    }

    // Slug folder template
    $folderName = Str::slug($request->name);

    // Path ke resources/views/templates
    $extractPath = resource_path("views/templates/$folderName");

    // Buat folder jika belum ada
    if (!file_exists($extractPath)) {
        mkdir($extractPath, 0755, true);
    }

    // Extract ZIP
    $zip->extractTo($extractPath);
    $zip->close();

    // Simpan thumbnail
    $thumb = $request->file('thumbnail')->store('templates', 'public');
    $preview = $request->file('preview')->store('preview', 'public');
    // Simpan ke database
    Template::create([
        'name' => $request->name,
        'slug' => $folderName,
        'thumbnail' => $thumb,
        'preview' => $preview,
        'category' => $request->category,
        'sections' => ["hero","couple","event","gallery","rsvp","music"],
        'is_active' => true
    ]);

    return back()->with('success', 'Template berhasil diupload & diekstrak ke views/templates!');
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
   public function preview($slug, $id)
    {
        // Ambil invitation + relasi
        $invitation = Invitation::with([
                'template',
                'galleries',
                'rsvps',
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        // Ambil template
        $template = Template::findOrFail($id);
        $template->increment('views_count');

        // Update template_id (Hanya jika login)
        if (auth()->check() && $invitation->template_id != $template->id) {
            $invitation->update([
                'template_id' => $template->id
            ]);

            // Refresh relasi template
            $invitation->load('template');
        } else {
            // Jika guest, kita "set" saja secara temporary di object agar bisa di-preview tanpa simpan ke DB
            $invitation->setRelation('template', $template);
        }

        // Tentukan view template
        $templateView = 'templates.' . $invitation->template->slug . '.index';

        // Safety: view template tidak ada
        if (!view()->exists($templateView)) {
            abort(404, 'Template tidak ditemukan');
        }

        return view($templateView, compact('invitation'));
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
