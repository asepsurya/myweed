<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Invitation;
use App\Models\Template;
use App\View\TemplateViewFinder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class TemplateCreatorController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Template::query();

        if ($request->filled('filter')) {
            $filter = $request->get('filter');
            if ($filter === 'mine') {
                $query->where('user_id', $user->id)->where('is_user_template', true);
            } elseif ($filter === 'system') {
                $query->where('is_user_template', false);
            }
        } else {
            $query->where(function ($q) use ($user) {
                $q->where('is_user_template', false)
                    ->orWhere(function ($q2) use ($user) {
                        $q2->where('is_user_template', true)->where('user_id', $user->id);
                    });
            });
        }

        $templates = $query->orderByDesc('is_user_template')->orderByDesc('created_at')->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('dashboard.template-creator.index', compact('templates', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $baseTemplates = Template::where('is_user_template', false)->where('is_active', true)->get();

        return view('dashboard.template-creator.create', [
            'categories' => $categories,
            'baseTemplates' => $baseTemplates,
            'template' => new Template,
        ]);
    }

    public function improvePrompt(Request $request)
    {
        set_time_limit(120);

        $request->validate([
            'prompt' => 'required|string|max:2000',
        ]);

        $prompt = $request->input('prompt');
        $systemPrompt = <<<'PROMPT'
Kamu adalah ahli prompt engineering untuk AI yang membuat template undangan pernikahan. Tugasmu adalah memperbaiki dan mengoptimalkan prompt pengguna agar lebih detail, jelas, dan mudah dipahami oleh AI.

ATURAN:
1. Tingkatkan prompt pengguna menjadi lebih spesifik dan terstruktur.
2. Tambahkan detail yang relevan untuk template undangan: gaya desain, warna, nuansa, elemen yang diinginkan, dan struktur yang diharapkan.
3. Jangan mengubah maksud awal pengguna.
4. Jangan gunakan markdown. Jawab dalam Bahasa Indonesia yang jelas.
5. Hasilkan HANYA prompt yang sudah diperbaiki, tanpa penjelasan tambahan.
6. Format hasilnya sebagai prompt tunggal yang siap dikirim ke AI generator template.
PROMPT;

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => "Perbaiki prompt ini: {$prompt}"],
        ];

        try {
            $aiServerUrl = rtrim(env('AI_SERVER_URL'), '/');
            $apiKey = env('AI_API_KEY');
            $primaryModel = env('AI_MODEL_PRIMARY', 'gpt-oss:120b-cloud');

            $payload = [
                'model' => $primaryModel,
                'messages' => $messages,
                'stream' => false,
                'options' => [
                    'temperature' => 0.7,
                    'top_p' => 0.9,
                    'num_ctx' => 4096,
                ],
            ];

            $response = Http::timeout(120)
                ->withHeaders(array_filter([
                    'Content-Type' => 'application/json',
                    'Authorization' => $apiKey ? 'Bearer '.$apiKey : null,
                ]))
                ->post($aiServerUrl.'/api/chat', $payload);

            if ($response->successful()) {
                $data = $response->json();
                $improved = $data['message']['content'] ?? $data['response'] ?? null;

                if (! $improved) {
                    return response()->json([
                        'success' => false,
                        'message' => 'AI tidak dapat memperbaiki prompt.',
                    ], 422);
                }

                return response()->json([
                    'success' => true,
                    'improved_prompt' => trim($improved),
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Layanan AI sedang sibuk. Coba lagi sebentar.',
            ], 502);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat terhubung ke layanan AI: '.$e->getMessage(),
            ], 502);
        }
    }

    public function generateWithAI(Request $request)
    {
        set_time_limit(180);

        $request->validate([
            'prompt' => 'required|string|max:2000',
            'base_template_id' => 'nullable|exists:templates,id',
            'style' => 'nullable|string|max:255',
            'color_scheme' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $prompt = $request->input('prompt');
        $baseTemplateId = $request->input('base_template_id');
        $style = $request->input('style') ?? 'modern';
        $colorScheme = $request->input('color_scheme') ?? '#1B2A4A dan #C6A962';

        $baseTemplate = $baseTemplateId ? Template::findOrFail($baseTemplateId) : null;

        $systemPrompt = $this->buildTemplateSystemPrompt($style, $colorScheme, $baseTemplate);

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => "Buatkan template undangan pernikahan dengan deskripsi: {$prompt}"],
        ];

        try {
            $aiServerUrl = rtrim(env('AI_SERVER_URL'), '/');
            $apiKey = env('AI_API_KEY');
            $primaryModel = env('AI_MODEL_PRIMARY', 'gpt-oss:120b-cloud');

            $payload = [
                'model' => $primaryModel,
                'messages' => $messages,
                'stream' => false,
                'options' => [
                    'temperature' => 0.7,
                    'top_p' => 0.9,
                    'num_ctx' => 8192,
                ],
            ];

            $response = Http::timeout(180)
                ->withHeaders(array_filter([
                    'Content-Type' => 'application/json',
                    'Authorization' => $apiKey ? 'Bearer '.$apiKey : null,
                ]))
                ->post($aiServerUrl.'/api/chat', $payload);

            if ($response->successful()) {
                $data = $response->json();
                $generatedCode = $data['message']['content'] ?? $data['response'] ?? null;

                if (! $generatedCode) {
                    return response()->json([
                        'success' => false,
                        'message' => 'AI tidak menghasilkan kode template.',
                    ], 422);
                }

                $cleanCode = $this->extractBladeCode($generatedCode);
                $cleanCode = $this->normalizeGeneratedCode($cleanCode);

                return response()->json([
                    'success' => true,
                    'code' => $cleanCode,
                    'raw' => $generatedCode,
                    'message' => 'Template berhasil digenerate oleh AI.',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Layanan AI sedang sibuk. Coba lagi sebentar.',
            ], 502);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat terhubung ke layanan AI: '.$e->getMessage(),
            ], 502);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'nullable|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $user = Auth::user();
        $slug = Str::slug($request->name).'-'.$user->id.'-'.uniqid();
        $r2Path = "templates/{$slug}/index.blade.php";

        Storage::disk('r2')->put($r2Path, $request->input('code'));

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $this->storeThumbnail($request->file('thumbnail'));
        }

        $template = Template::create([
            'name' => $request->name,
            'slug' => $slug,
            'thumbnail' => $thumbnailPath ?? 'templates/placeholder.png',
            'user_id' => $user->id,
            'is_user_template' => true,
            'sections' => ['hero', 'couple', 'event', 'gallery', 'rsvp', 'music'],
            'is_active' => true,
            'description' => $request->input('description'),
            'ai_prompt' => $request->input('ai_prompt') ?: null,
        ]);

        return redirect()
            ->route('template-creator.index')
            ->with('success', 'Template berhasil dibuat!');
    }

    public function edit(Template $template)
    {
        $this->authorizeTemplate($template);

        $categories = Category::orderBy('name')->get();
        $baseTemplates = Template::where('is_user_template', false)->where('is_active', true)->get();

        $r2Path = "templates/{$template->slug}/index.blade.php";
        $code = '';
        try {
            if (Storage::disk('r2')->exists($r2Path)) {
                $code = Storage::disk('r2')->get($r2Path);
            }
        } catch (\Throwable $e) {
            $code = '';
        }

        return view('dashboard.template-creator.create', array_merge(compact('template', 'categories', 'baseTemplates'), ['code' => $code]));
    }

    public function update(Request $request, Template $template)
    {
        $this->authorizeTemplate($template);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'nullable|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $slug = $template->slug;
        $r2Path = "templates/{$slug}/index.blade.php";

        Storage::disk('r2')->put($r2Path, $request->input('code'));

        /** @var TemplateViewFinder $finder */
        $finder = app('view.finder');
        $finder->clearCache($slug);

        if ($request->hasFile('thumbnail')) {
            $thumb = $this->storeThumbnail($request->file('thumbnail'));
            $template->update(['thumbnail' => $thumb]);
        }

        $template->update([
            'name' => $request->name,
            'description' => $request->input('description'),
        ]);

        return redirect()
            ->route('template-creator.index')
            ->with('success', 'Template berhasil diperbarui!');
    }

    public function destroy(Request $request, Template $template)
    {
        $this->authorizeTemplate($template);

        Storage::disk('r2')->deleteDirectory("templates/{$template->slug}");

        /** @var TemplateViewFinder $finder */
        $finder = app('view.finder');
        $finder->clearCache($template->slug);

        if ($template->thumbnail && Storage::disk('public')->exists($template->thumbnail)) {
            Storage::disk('public')->delete($template->thumbnail);
        }

        $template->delete();

        return redirect()
            ->route('template-creator.index')
            ->with('success', 'Template berhasil dihapus.');
    }

    public function preview(Template $template)
    {
        $this->authorizeTemplate($template);

        $invitation = new Invitation([
            'slug' => 'preview-'.$template->id,
            'groom_name' => 'Romeo',
            'groom_nickname' => 'Romeo',
            'bride_name' => 'Juliet',
            'bride_nickname' => 'Juliet',
            'wedding_date' => now()->addMonths(2)->format('Y-m-d'),
            'akad_location' => 'Masjid Raya',
            'resepsi_location' => 'Gedung Serbaguna',
            'enable_rsvp' => true,
            'enable_gift' => true,
            'enable_gallery' => true,
            'enable_music' => true,
            'enable_video' => true,
            'enable_love_story' => true,
        ]);
        $invitation->id = 0;
        $invitation->setRelation('template', $template);
        $invitation->setRelation('galleries', collect([]));
        $invitation->setRelation('rsvps', collect([]));

        $templateView = 'templates.'.$template->slug.'.index';

        if (! view()->exists($templateView)) {
            return response('Template view tidak ditemukan: '.$templateView, 404);
        }

        return view($templateView, compact('invitation'));
    }

    public function editCode(Template $template)
    {
        $this->authorizeTemplate($template);

        $r2Path = "templates/{$template->slug}/index.blade.php";
        $code = '';

        try {
            if (Storage::disk('r2')->exists($r2Path)) {
                $code = Storage::disk('r2')->get($r2Path);
            }
        } catch (\Throwable $e) {
            $code = '';
        }

        return view('dashboard.template-creator.code-editor', compact('template', 'code'));
    }

    public function saveCode(Request $request, Template $template)
    {
        $this->authorizeTemplate($template);

        $request->validate([
            'code' => 'required|string',
        ]);

        $r2Path = "templates/{$template->slug}/index.blade.php";

        Storage::disk('r2')->put($r2Path, $request->input('code'));

        /** @var \App\View\TemplateViewFinder $finder */
        $finder = app('view.finder');
        $finder->clearCache($template->slug);

        return back()->with('success', 'Template berhasil diperbarui!');
    }

    public function previewCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = $request->input('code');
        $tempSlug = 'preview-code-'.uniqid();
        $r2Path = "templates/{$tempSlug}/index.blade.php";

        Storage::disk('r2')->put($r2Path, $code);

        $template = new Template([
            'slug' => $tempSlug,
            'name' => 'Preview',
        ]);
        $template->id = 0;

        $invitation = new Invitation([
            'slug' => 'preview-'.$tempSlug,
            'groom_name' => 'Romeo',
            'groom_nickname' => 'Romeo',
            'groom_father_name' => 'Ahmad',
            'groom_mother_name' => 'Siti',
            'foto_pria' => 'default/groom.jpg',
            'bride_name' => 'Juliet',
            'bride_nickname' => 'Juliet',
            'bride_father_name' => 'Budi',
            'bride_mother_name' => 'Dewi',
            'foto_wanita' => 'default/bride.jpg',
            'wedding_date' => now()->addMonths(2)->format('Y-m-d'),
            'akad_location' => 'Masjid Raya',
            'akad_time' => '08:00:00',
            'akad_time_end' => '10:00:00',
            'akad_address' => 'Jl. Masjid Raya No. 1',
            'akad_maps' => 'https://maps.google.com',
            'resepsi_location' => 'Gedung Serbaguna',
            'resepsi_time' => '11:00:00',
            'resepsi_time_end' => '13:00:00',
            'resepsi_address' => 'Jl. Gedung No. 1',
            'resepsi_maps' => 'https://maps.google.com',
            'enable_rsvp' => true,
            'enable_gift' => true,
            'enable_gallery' => true,
            'enable_music' => true,
            'enable_video' => true,
            'enable_love_story' => true,
            'gallery_cover' => 'default/cover.jpg',
            'wedding_quote' => 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
            'quote_id' => 'QS. Ar-Rum: 21',
            'groom_instagram' => '@romeo',
            'bride_instagram' => '@juliet',
        ]);
        $invitation->id = 0;
        $invitation->setRelation('template', $template);
        $invitation->setRelation('galleries', collect([
            (object) ['image' => 'default/gallery1.jpg'],
            (object) ['image' => 'default/gallery2.jpg'],
            (object) ['image' => 'default/gallery3.jpg'],
        ]));
        $invitation->setRelation('rsvps', collect([]));
        $invitation->setRelation('gifts', collect([
            (object) ['bank' => 'BCA', 'number' => '1234567890', 'name' => 'Romeo'],
            (object) ['bank' => 'Mandiri', 'number' => '0987654321', 'name' => 'Juliet'],
        ]));

        $templateView = 'templates.'.$tempSlug.'.index';

        if (! view()->exists($templateView)) {
            return response('Template view tidak ditemukan: '.$templateView, 404);
        }

        return view($templateView, compact('invitation'));
    }

    private function authorizeTemplate($template): void
    {
        $user = Auth::user();
        if ($template->is_user_template && $template->user_id !== $user->id && ! $user->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki akses ke template ini.');
        }
    }

    private function storeThumbnail($file): string
    {
        $dir = storage_path('app/public/templates');
        if (! file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = uniqid().'.webp';
        $destFile = $dir.'/'.$filename;

        try {
            $driver = new Driver;
            $manager = new ImageManager($driver);
            $image = $manager->read($file->getRealPath());
            $image->save($destFile, 75, 'webp');
        } catch (\Throwable $e) {
            $file->move($dir, $filename);
        }

        return 'templates/'.$filename;
    }

    private function buildTemplateSystemPrompt(string $style, string $colorScheme, ?Template $baseTemplate): string
    {
        $basePrompt = <<<PROMPT
Kamu adalah ahli desainer web dan pengembang template undangan pernikahan digital. Tugasmu adalah menghasilkan kode Blade PHP lengkap untuk template undangan pernikahan yang FLEXIBLE dan MODULAR seperti template luxe-amour.

STRUKTUR FLEXIBLE TEMPLATE (WAJIB DIIKUTI):
1. DOCTYPE html dengan lang="id"
2. Meta tags untuk Open Graph (Facebook) dan Twitter
3. Google Fonts (minimal 2 font: serif seperti Playfair Display + sans seperti Lato)
4. Library CDN: Fancybox, Tabler Icons, jQuery (jika diperlukan)
5. CSS VARIABLES di :root (HARUS ADA DAN KONSISTEN):
   --primary-color: {$colorScheme}
   --secondary-color: (pilih warna aksen yang cocok dari palette yang sama)
   --text-dark: #2C2C2C
   --text-muted: #666666
   --bg-color: (warna background utama, biasanya #FAF9F6 atau serupa)
   --white: #FFFFFF
   --border-color: rgba(0,0,0,0.1)
   --transition: all 0.3s ease
   - WAJIB: Gunakan variabel ini di SEMUA properti CSS, JANGAN hardcode warna berulang kali
   - Contoh: color: var(--primary-color); background: var(--bg-color); border-color: var(--border-color);

6. SECTION ORDER WAJIB (sama seperti luxe-amour):
   - Hero (nama mempelai, tanggal, tombol "Buka Undangan")
   - Quote/Doa (wedding_quote, quote_id)
   - Mempelai (foto, nama, nama ortu, Instagram)
   - Event (akad + resepsi dengan waktu, lokasi, maps)
   - Countdown (hitungan mundur)
   - Galeri (masonry gallery)
   - Gift/Amplop (jika enable_gift aktif)
   - RSVP/Doa & Ucapan (jika enable_rsvp aktif)
   - Footer

7. EXACT DATABASE FIELDS DARI MODEL INVITATION (WAJIB PAKAI NAMA KOLOM INI):

   DATA MEMPELAI:
   - groom_name, groom_nickname, groom_father_name, groom_mother_name, groom_instagram, groom_username_instagram
   - bride_name, bride_nickname, bride_father_name, bride_mother_name, bride_instagram, bride_username_instagram

   DATA ACARA:
   - wedding_date (format Y-m-d)
   - akad_time, akad_time_end, akad_location, akad_address, akad_maps
   - resepsi_time, resepsi_time_end, resepsi_location, resepsi_address, resepsi_maps

   DATA MEDIA:
   - gallery_cover (path gambar cover hero)
   - foto_pria (path foto mempelai pria)
   - foto_wanita (path foto mempelai wanita)
   - galleries (relasi hasMany Gallery, setiap item punya field 'image')
   - gifts (relasi hasMany Gift, setiap item punya field 'bank', 'number', 'name')

   DATA LAIN:
   - wedding_quote, quote_id (opsional)
   - enable_rsvp (0 atau 1), enable_gift (0 atau 1)
   - music_youtube_url (URL YouTube untuk music player)
   - love_story (array JSON)
   - rsvps (relasi hasMany Rsvp)

   CONTOH PENGGUNAAN YANG BENAR:
    - Nama pria: {{ \$invitation->groom_name ?? 'Mempelai Pria' }}
    - Nama wanita: {{ \$invitation->bride_name ?? 'Mempelai Wanita' }}
    - Foto pria: <img src="{{ asset('storage/' . (\$invitation->foto_pria ?? 'default/groom.jpg')) }}">
    - Foto wanita: <img src="{{ asset('storage/' . (\$invitation->foto_wanita ?? 'default/bride.jpg')) }}">
    - Cover hero: background-image: url('{{ asset('storage/' . (\$invitation->gallery_cover ?? 'default/cover.jpg')) }}')
    - Gallery: @foreach(\$invitation->galleries as \$photo) <img src="{{ asset('storage/' . \$photo->image) }}"> @endforeach
    - Gift: @foreach(\$invitation->gifts as \$gift) {{ \$gift->bank }} - {{ \$gift->number }} @endforeach
    - RSVP form action: action="{{ route('rsvp.store', \$invitation->id) }}"
    - Music: @if(\$invitation->music_youtube_url) <iframe src="{{ \$invitation->music_youtube_url }}"></iframe> @endif

8. ROUTE YANG SUDAH ADA (PAKAI NAMA ROUTE INI):
   - RSVP store: route('rsvp.store', \$invitation->id)
   - RSVP list: route('rsvp.list', \$invitation->id)
   - JANGAN buat route baru seperti rsvp.submit, rsvp.send, dll.

9. CSS CLASS NAMING (konsisten dengan template lain):
   - .hero, .fade-in, .visible, .masonry-gallery, .masonry-item
   - .btn-outline, .event-card, .gift-card, .rsvp-form
   - .section-padding, .hero-subtitle, .serif-font, .script-font

10. RESPONSIVE DESIGN:
    - Mobile first: container max-width 414px untuk mobile
    - Desktop: media query min-width 1024px untuk split screen layout
    - Gunakan flexbox dan grid yang responsif

11. Gunakan variabel \$invitation untuk SEMUA data dinamis
12. Format tanggal: d M Y atau d F Y (bahasa Indonesia)
13. Gunakan asset('storage/...) untuk gambar dari storage
14. TAMBAHKAN FALLBACK untuk gambar: jika field gambar kosong, gunakan placeholder default

ATURAN TAMBAHAN:
- Hasilkan HANYA kode Blade PHP lengkap, tanpa penjelasan, tanpa markdown code block, tanpa teks pembuka/penutup.
- Gunakan <style> tag di dalam template, JANGAN file CSS eksternal.
- Template harus standalone dan dapat di-customize hanya dengan mengubah CSS variables di :root.
- Jangan gunakan {{ asset() }} untuk file lokal kecuali untuk storage.
- Gunakan route() untuk URL internal.
- Pastikan ada music player jika ada musik.
- Tambahkan animasi scroll reveal dengan Intersection Observer.
- GUNAKAN NAMA FIELD DARI DATABASE YANG SEBENARNYA, JANGAN MENEMUKAN-NEMUKAN NAMA FIELD.
PROMPT;

        if ($baseTemplate) {
            $basePrompt .= "\n\nReferensi template dasar: {$baseTemplate->name} (slug: {$baseTemplate->slug}). ikut struktur dan styling yang serupa.";
        }

        return $basePrompt;
    }

    private function extractBladeCode(string $raw): string
    {
        $raw = trim($raw);

        if (str_starts_with($raw, '```blade')) {
            $raw = preg_replace('/^```blade\s*/', '', $raw);
        } elseif (str_starts_with($raw, '```php')) {
            $raw = preg_replace('/^```php\s*/', '', $raw);
        } elseif (str_starts_with($raw, '```html')) {
            $raw = preg_replace('/^```html\s*/', '', $raw);
        } elseif (str_starts_with($raw, '```')) {
            $raw = preg_replace('/^```\s*/', '', $raw);
        }

        $raw = preg_replace('/\s*```\s*$/', '', $raw);

        if (str_starts_with($raw, '<!DOCTYPE html>') || str_starts_with($raw, '<html')) {
            return $raw;
        }

        if (str_starts_with($raw, '@')) {
            $raw = '<!DOCTYPE html>'."\n".'<html lang="id">'."\n".$raw."\n".'</html>';
        }

        return $raw;
    }

    private function normalizeGeneratedCode(string $code): string
    {
        $replacements = [
            'nama_pria' => 'groom_name',
            'nama_wanita' => 'bride_name',
            'tanggal_akad' => 'wedding_date',
            'waktu_akad' => 'akad_time',
            'waktu_resepsi' => 'resepsi_time',
            'lokasi_akad' => 'akad_location',
            'lokasi_resepsi' => 'resepsi_location',
            'maps_link' => 'akad_maps',
            'instagram_pria' => 'groom_instagram',
            'instagram_wanita' => 'bride_instagram',
            'music_url' => 'music_youtube_url',

            "route('rsvp.submit', \$invitation->id)" => "route('rsvp.store', \$invitation->id)",
            "route('rsvp.send', \$invitation->id)" => "route('rsvp.store', \$invitation->id)",
            "route('rsvp.post', \$invitation->id)" => "route('rsvp.store', \$invitation->id)",
        ];

        foreach ($replacements as $wrong => $correct) {
            $code = str_replace($wrong, $correct, $code);
        }

        $code = preg_replace(
            "/asset\('storage\/' \. \$invitation->(gallery_cover|foto_pria|foto_wanita)\)/",
            "asset('storage/' . (\$invitation->$1 ?? 'default/placeholder.jpg'))",
            $code
        );

        return $code;
    }
}
