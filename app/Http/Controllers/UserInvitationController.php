<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Gift;
use App\Models\Invitation;
use App\Models\Music;
use App\Models\Subscription;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;

class UserInvitationController extends Controller
{
    private function ensureFeature(Request $request, string $feature, string $message): ?RedirectResponse
    {
        $user = $request->user();

        if ($user->isAdmin() || $user->hasFeature($feature)) {
            return null;
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 403);
        }

        return redirect()->back()->with('error', $message);
    }

    public function index()
    {
        $invitations = Invitation::with('user')->get();

        return view('dashboard.invitation.index', compact('invitations'));
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        // Check Limit for Non-Subscribed Users
        if (! $user->isSubscribed() && Invitation::where('user_id', $user->id)->count() >= 1) {
            return redirect()->route('dashboard.user')->with('error', 'Versi gratis hanya diperbolehkan membuat 1 undangan. Silakan aktifkan Paket Subscription untuk membuat lebih banyak! ✨');
        }

        $music = Music::where('is_active', true)->get();
        $templates = Template::where('is_active', true)->paginate(6);
        $selectedTemplateId = $request->template_id;

        return view('dashboard.invitation.create', compact('templates', 'music', 'selectedTemplateId'));
    }

    public function quickCreate(Request $request)
    {
        $request->validate([
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'groom_nickname' => 'nullable|string|max:255',
            'bride_nickname' => 'nullable|string|max:255',
            'groom_child_order' => 'nullable|string|max:255',
            'bride_child_order' => 'nullable|string|max:255',
            'template_id' => 'nullable|exists:templates,id',
        ], [
            'groom_name.required' => 'Nama mempelai pria wajib diisi.',
            'bride_name.required' => 'Nama mempelai wanita wajib diisi.',
            'template_id.exists' => 'Template yang dipilih tidak valid.',
        ]);

        $baseSlug = Str::slug(
            ($request->groom_nickname ?: $request->groom_name).'-'.($request->bride_nickname ?: $request->bride_name)
        );

        $slug = $baseSlug;
        $counter = 1;
        while (Invitation::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter++;
        }

        $user = $request->user();

        if (! $user->isAdmin() && ! $user->isSubscribed()) {
            $existing = Invitation::where('user_id', $user->id)->first();
            if ($existing && $existing->slug !== $slug) {
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda hanya dapat membuat satu undangan. Upgrade ke berlangganan untuk membuat undangan tanpa batas.',
                    ], 403);
                }

                return redirect()
                    ->back()
                    ->with('error', 'Anda hanya dapat membuat satu undangan. Upgrade ke berlangganan untuk membuat undangan tanpa batas.');
            }
        }

        $templateId = $request->template_id ?? 2;

        $invitation = Invitation::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'slug' => $slug,
            ],
            [
                'template_id' => $templateId,
                'groom_name' => $request->groom_name,
                'groom_nickname' => $request->groom_nickname,
                'groom_child_order' => $request->groom_child_order,
                'bride_name' => $request->bride_name,
                'bride_nickname' => $request->bride_nickname,
                'bride_child_order' => $request->bride_child_order,
            ]
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Undangan berhasil dibuat',
                'invitation' => $invitation,
                'redirect_url' => route('invitation.edit', $invitation),
            ]);
        }

        return redirect()
            ->route('invitation.edit', $invitation)
            ->with('success', 'Undangan berhasil dibuat 💖');
    }

    private function uploadImageAsWebP($file, $fullPath, $maxWidth = null)
    {
        if (! $file->isValid() || ! str_starts_with($file->getMimeType(), 'image/')) {
            throw new \Exception('File upload tidak valid atau bukan gambar. MIME: '.$file->getMimeType().', isValid: '.($file->isValid() ? 'yes' : 'no'));
        }

        $fullPath = preg_replace('/\.(jpe?g|png|gif|webp)$/i', '.webp', $fullPath);

        $folder = pathinfo($fullPath, PATHINFO_DIRNAME);
        if (! Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->makeDirectory($folder, 0755, true);
        }

        $content = file_get_contents($file->getRealPath());

        if ($content === false) {
            throw new \Exception('Gagal membaca file: '.$file->getRealPath());
        }

        if ($maxWidth && str_starts_with($file->getMimeType(), 'image/')) {
            try {
                $driver = new GdDriver;
                $manager = new ImageManager($driver);
                $image = $manager->read($file->getRealPath());

                if ($image->width() > $maxWidth) {
                    $image->scale(width: $maxWidth);
                }

                $encoded = $image->toWebp(75);
                $content = (string) $encoded;
            } catch (\Throwable $e) {
                \Log::warning('GD resize failed, saving original: '.$e->getMessage());
            }
        }

        if (strlen($content) === 0) {
            throw new \Exception("File content is empty for: {$fullPath}");
        }

        $saved = Storage::disk('public')->put($fullPath, $content);

        \Log::debug('uploadImageAsWebP saved', [
            'path' => $fullPath,
            'size' => strlen($content),
            'storage_result' => $saved,
            'file_exists' => Storage::disk('public')->exists($fullPath),
        ]);

        if (! $saved || ! Storage::disk('public')->exists($fullPath)) {
            $errorPath = Storage::disk('public')->path($fullPath);
            throw new \Exception("Gagal menyimpan file ke storage: {$fullPath} (path: {$errorPath})");
        }

        return $fullPath;
    }

    public function store(Request $request)
    {
        $request->validate([
            'bride_name' => 'required|string|max:255',
            'groom_name' => 'required|string|max:255',
            'wedding_date' => 'required|date',
            'template_id' => 'required|exists:templates,id',
            'theme_color' => 'nullable|string|max:255',
            'primary_color' => 'nullable|string|max:7',
            'groom_child_order' => 'nullable|string|max:255',
            'bride_child_order' => 'nullable|string|max:255',

            'gallery.*' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp|max:10240',
            'gallery_cover' => 'nullable|file|mimes:jpeg,jpg,png,webp|max:10240',
            'custom_music' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'foto_pria' => 'nullable|file|mimes:jpeg,jpg,png,webp|max:10240',
            'foto_wanita' => 'nullable|file|mimes:jpeg,jpg,png,webp|max:10240',
            'love_story.*' => 'nullable|string|max:5000',
            'story_photo.*' => 'nullable|file|mimes:jpeg,jpg,png,webp|max:10240',
        ], [
            'bride_name.required' => 'Nama mempelai wanita wajib diisi.',
            'bride_name.string' => 'Nama mempelai wanita harus berupa teks.',
            'bride_name.max' => 'Nama mempelai wanita tidak boleh melebihi :max karakter.',
            'groom_name.required' => 'Nama mempelai pria wajib diisi.',
            'groom_name.string' => 'Nama mempelai pria harus berupa teks.',
            'groom_name.max' => 'Nama mempelai pria tidak boleh melebihi :max karakter.',
            'groom_child_order.string' => 'Urutan anak mempelai pria harus berupa teks.',
            'groom_child_order.max' => 'Urutan anak mempelai pria tidak boleh melebihi :max karakter.',
            'bride_child_order.string' => 'Urutan anak mempelai wanita harus berupa teks.',
            'bride_child_order.max' => 'Urutan anak mempelai wanita tidak boleh melebihi :max karakter.',
            'wedding_date.required' => 'Tanggal pernikahan wajib diisi.',
            'wedding_date.date' => 'Tanggal pernikahan harus berupa tanggal yang valid.',
            'template_id.required' => 'Template undangan wajib dipilih.',
            'template_id.exists' => 'Template yang dipilih tidak valid.',
            'gallery.*.mimes' => 'File galeri harus berupa gambar (jpeg, jpg, png, gif, webp).',
            'gallery.*.max' => 'File galeri tidak boleh melebihi :max kilobyte.',
            'gallery_cover.mimes' => 'Cover galeri harus berupa gambar (jpeg, jpg, png, webp).',
            'gallery_cover.max' => 'Cover galeri tidak boleh melebihi :max kilobyte.',
            'custom_music.mimes' => 'File musik harus berupa audio (mp3, wav, ogg).',
            'custom_music.max' => 'File musik tidak boleh melebihi :max kilobyte.',
            'foto_pria.mimes' => 'Foto mempelai pria harus berupa gambar (jpeg, jpg, png, webp).',
            'foto_pria.max' => 'Foto mempelai pria tidak boleh melebihi :max kilobyte.',
            'foto_wanita.mimes' => 'Foto mempelai wanita harus berupa gambar (jpeg, jpg, png, webp).',
            'foto_wanita.max' => 'Foto mempelai wanita tidak boleh melebihi :max kilobyte.',
        ]);

        $baseSlug = Str::slug($request->groom_nickname.'-'.$request->bride_nickname);

        $user = auth()->user();
        // Double check limit for store
        if (! $user->isSubscribed() && Invitation::where('user_id', $user->id)->count() >= 1) {
            return redirect()->route('dashboard.user')->with('error', 'Limit tercapai. Aktifkan Paket Subscription untuk membuat lebih banyak undangan.');
        }

        // Check Template Premium Access
        $template = Template::findOrFail($request->template_id);
        if ($template->is_premium && ! $user->hasFeature('all_themes')) {
            return redirect()->back()->with('error', 'Template Premium hanya tersedia untuk member aktif! ✨');
        }

        // Check RSVP feature
        if ($request->has('enable_rsvp') && ! $user->hasFeature('rsvp_messages')) {
            return redirect()->back()->with('error', 'Fitur RSVP hanya tersedia untuk paket berbayar.');
        }

        // Check Gallery feature
        if ($request->hasFile('gallery') && ! $user->hasFeature('gallery')) {
            return redirect()->back()->with('error', 'Fitur Galeri hanya tersedia untuk paket berbayar.');
        }

        $galleryLimit = data_get($user->subscription->plan->features ?? [], 'gallery_limit');
        if ($request->hasFile('gallery') && ! is_null($galleryLimit) && count($request->file('gallery')) > $galleryLimit) {
            return redirect()->back()->with('error', "Maksimal {$galleryLimit} foto untuk paket ini.");
        }

        // Check Love Story feature
        if ($request->has('love_story') && ! $user->hasFeature('love_story')) {
            return redirect()->back()->with('error', 'Fitur Kisah Cinta hanya tersedia untuk paket berbayar.');
        }

        // Check Custom Music feature
        if ($request->hasFile('custom_music') && ! $user->hasFeature('custom_music')) {
            return redirect()->back()->with('error', 'Fitur Custom Music hanya tersedia untuk paket berbayar.');
        }

        // Check Streaming Video feature
        if ($request->filled('video_link') && ! $user->hasFeature('streaming_video')) {
            return redirect()->back()->with('error', 'Fitur Link Video hanya tersedia untuk paket berbayar.');
        }

        // Check Virtual Gift feature
        if ($request->has('enable_gift') && $request->enable_gift && ! $user->hasFeature('virtual_gift')) {
            return redirect()->back()->with('error', 'Fitur Hadiah Digital hanya tersedia untuk paket berbayar.');
        }

        // Check if same user already has this slug → redirect to edit
        $existingInvitation = Invitation::where('slug', $baseSlug)
            ->where('user_id', $request->user()->id)
            ->first();

        if ($existingInvitation) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Undangan sudah ada, redirecting to edit mode',
                    'invitation' => $existingInvitation,
                    'redirect_to_edit' => true,
                ]);
            }

            return redirect()
                ->route('invitation.edit', $existingInvitation)
                ->with('success', 'Undangan sudah ada, Anda dialihkan ke halaman edit.');
        }

        // Ensure global slug uniqueness - append numeric suffix if needed
        $slug = $baseSlug;
        $counter = 1;
        while (Invitation::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter++;
        }

        $user = $request->user();

        if (! $user->isAdmin() && ! $user->isSubscribed()) {
            $hasExisting = Invitation::where('user_id', $user->id)->exists();
            if ($hasExisting) {
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda hanya dapat membuat satu undangan. Upgrade ke berlangganan untuk membuat undangan tanpa batas.',
                    ], 403);
                }

                return redirect()
                    ->back()
                    ->with('error', 'Anda hanya dapat membuat satu undangan. Upgrade ke berlangganan untuk membuat undangan tanpa batas.');
            }
        }

        $invitation = null;

        DB::transaction(function () use ($request, $slug, &$invitation) {

            $stories = [];

            if ($request->has('love_story')) {
                foreach ($request->love_story as $index => $storyText) {

                    $photoPath = null;

                    if ($request->hasFile('story_photo.'.$index)) {
                        $photoPath = $this->uploadImageAsWebP(
                            $request->file('story_photo.'.$index),
                            'love_story/'.uniqid().'.webp'
                        );
                    }

                    $stories[] = [
                        'title' => $request->story_title[$index] ?? null,
                        'story' => $storyText,
                        'photo' => $photoPath,
                    ];
                }
            }
            $baseSlug = Str::slug($request->groom_name.'-'.$request->bride_name);
            $slug = $baseSlug;
            $counter = 1;
            while (Invitation::where('slug', $slug)->exists()) {
                $slug = $baseSlug.'-'.$counter;
                $counter++;
            }

            $invitation = Invitation::create([
                'user_id' => auth()->user()->id,
                'template_id' => $request->template_id,
                'status' => 'published',
                'slug' => $slug,

                'groom_name' => $request->groom_name,
                'groom_nickname' => $request->groom_nickname,
                'groom_father_name' => $request->groom_father_name,
                'groom_mother_name' => $request->groom_mother_name,
                'groom_child_order' => $request->groom_child_order,

                'bride_name' => $request->bride_name,
                'bride_nickname' => $request->bride_nickname,
                'bride_father_name' => $request->bride_father_name,
                'bride_mother_name' => $request->bride_mother_name,
                'bride_child_order' => $request->bride_child_order,

                'wedding_date' => $request->wedding_date,

                'akad_location' => $request->akad_location,
                'akad_time' => $request->akad_time,
                'akad_time_end' => $request->akad_time_end,
                'akad_maps' => $request->akad_maps,

                'resepsi_location' => $request->resepsi_location,
                'resepsi_time' => $request->resepsi_time,
                'resepsi_time_end' => $request->filled('sampai_selesai') ? 'Selesai' : $request->resepsi_time_end,
                'resepsi_maps' => $request->resepsi_maps,

                'theme_color' => $request->theme_color,
                'quote_id' => $request->quote_id,
                'wedding_quote' => $request->wedding_quote,
                'video_link' => $request->video_link,
                'youtube_url' => $request->youtube_url,
                'love_story' => $stories,

                'enable_rsvp' => $request->has('enable_rsvp'),
                'enable_gift' => $request->has('enable_gift'),

                'groom_instagram' => $request->groom_instagram,
                'groom_username_instagram' => $request->groom_username_instagram,
                'bride_instagram' => $request->bride_instagram,
                'bride_username_instagram' => $request->bride_username_instagram,
                'akad_address' => $request->akad_address,
                'resepsi_address' => $request->resepsi_address,

                'rsvp_deadline' => $request->rsvp_deadline,
                'rsvp_message' => $request->rsvp_message,
                'rsvp_whatsapp' => $request->rsvp_whatsapp,
                'primary_color' => $request->primary_color ?? '#0d9488',

            ]);
            if ($request->hasFile('foto_pria')) {
                try {
                    $path = "invitations/{$invitation->id}/pria/pria.webp";

                    $this->uploadImageAsWebP(
                        $request->file('foto_pria'),
                        $path,
                        1200
                    );

                    $invitation->update([
                        'foto_pria' => $path,
                    ]);
                } catch (\Throwable $e) {
                    \Log::error('Foto pria upload failed: '.$e->getMessage());
                }
            }

            if ($request->hasFile('foto_wanita')) {
                try {
                    $path = "invitations/{$invitation->id}/wanita/wanita.webp";

                    $this->uploadImageAsWebP(
                        $request->file('foto_wanita'),
                        $path,
                        1200
                    );

                    $invitation->update([
                        'foto_wanita' => $path,
                    ]);
                } catch (\Throwable $e) {
                    \Log::error('Foto wanita upload failed: '.$e->getMessage());
                }
            }

            if ($request->hasFile('gallery_cover')) {
                try {
                    $path = "invitations/{$invitation->id}/cover/cover.webp";

                    $this->uploadImageAsWebP(
                        $request->file('gallery_cover'),
                        $path,
                        1600
                    );

                    $invitation->update(['gallery_cover' => $path]);
                } catch (\Throwable $e) {
                    \Log::error('Gallery cover upload failed: '.$e->getMessage());
                }
            }

            if ($request->hasFile('custom_music')) {
                $musicPath = $request->file('custom_music')
                    ->store("invitations/{$invitation->id}/music", 'public');

                $invitation->update(['music' => $musicPath]);
            } else {
                $invitation->update([
                    'music' => $request->music_id,
                ]);
            }

            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $index => $imageFile) {
                    try {
                        $folder = "invitations/{$invitation->id}/gallery";

                        if (! Storage::disk('public')->exists($folder)) {
                            Storage::disk('public')->makeDirectory($folder, 0755, true);
                        }

                        $path = $this->uploadImageAsWebP(
                            $imageFile,
                            $folder.'/'.uniqid().'.webp'
                        );

                        Gallery::create([
                            'invitation_id' => $invitation->id,
                            'image' => $path,
                        ]);
                    } catch (\Throwable $e) {
                        \Log::error('Gallery upload failed: '.$e->getMessage());
                    }
                }
            }
            if ($request->has('enable_gift') && $request->enable_gift) {
                $banks = $request->bank;
                $numbers = $request->number;
                $names = $request->name;
                $qrs = $request->file('qr');

                foreach ($banks as $i => $bank) {
                    $giftData = [
                        'invitation_id' => $invitation->id,
                        'bank' => $bank,
                        'number' => $numbers[$i] ?? null,
                        'name' => $names[$i] ?? null,
                    ];

                    if (isset($qrs[$i])) {
                        try {
                            $giftData['qr'] = $this->uploadImageAsWebP(
                                $qrs[$i],
                                'gifts/'.uniqid().'.webp'
                            );
                        } catch (\Throwable $e) {
                            \Log::error('Gift QR upload failed: '.$e->getMessage());
                        }
                    }

                    Gift::create($giftData);
                }
            }
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Undangan berhasil dibuat',
                'invitation' => $invitation->fresh(),
            ]);
        }

        return redirect()
            ->route('invitation.index')
            ->with('success', 'Undangan berhasil dibuat 💖');
    }

    public function edit(Invitation $invitation)
    {
        $music = Music::where('is_active', true)->get();
        $templates = Template::where('is_active', true)->with('category')->get();

        return view('dashboard.invitation.edit', compact('invitation', 'music', 'templates'));
    }

    public function update(Request $request, Invitation $invitation)
    {
        $user = auth()->user();
        // Check Template Access
        $template = Template::findOrFail($request->template_id);
        if (! $user->hasFeature('all_themes') && $template->slug !== 'simple-theme') {
            return redirect()->back()->with('error', 'Template ini hanya tersedia untuk paket berbayar. Upgrade untuk mengakses semua tema.');
        }

        // Check RSVP feature
        if ($request->has('enable_rsvp') && ! $user->hasFeature('rsvp_messages')) {
            return redirect()->back()->with('error', 'Fitur RSVP hanya tersedia untuk paket berbayar.');
        }

        // Check Gallery feature
        if ($request->hasFile('gallery') && ! $user->hasFeature('gallery')) {
            return redirect()->back()->with('error', 'Fitur Galeri hanya tersedia untuk paket berbayar.');
        }

        $galleryLimit = data_get($user->subscription->plan->features ?? [], 'gallery_limit');
        if ($request->hasFile('gallery') && ! is_null($galleryLimit) && count($request->file('gallery')) > $galleryLimit) {
            return redirect()->back()->with('error', "Maksimal {$galleryLimit} foto untuk paket ini.");
        }

        // Check Love Story feature
        if ($request->has('love_story') && ! $user->hasFeature('love_story')) {
            return redirect()->back()->with('error', 'Fitur Kisah Cinta hanya tersedia untuk paket berbayar.');
        }

        // Check Custom Music feature
        if ($request->hasFile('custom_music') && ! $user->hasFeature('custom_music')) {
            return redirect()->back()->with('error', 'Fitur Custom Music hanya tersedia untuk paket berbayar.');
        }

        // Check Streaming Video feature
        if ($request->filled('video_link') && ! $user->hasFeature('streaming_video')) {
            return redirect()->back()->with('error', 'Fitur Link Video hanya tersedia untuk paket berbayar.');
        }

        // Check Virtual Gift feature
        if ($request->enable_gift == 1 && ! $user->hasFeature('virtual_gift')) {
            return redirect()->back()->with('error', 'Fitur Hadiah Digital hanya tersedia untuk paket berbayar.');
        }

        $request->validate([
            'bride_name' => 'required|string|max:255',
            'groom_name' => 'required|string|max:255',
            'wedding_date' => 'required|date',
            'template_id' => 'required|exists:templates,id',
            'theme_color' => 'nullable|string|max:255',
            'primary_color' => 'nullable|string|max:7',
            'gallery.*' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp|max:10240',
            'gallery_cover' => 'nullable|file|mimes:jpeg,jpg,png,webp|max:10240',
            'custom_music' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'music_youtube_url' => 'nullable|url',
            'foto_pria' => 'nullable|file|mimes:jpeg,jpg,png,webp|max:10240',
            'foto_wanita' => 'nullable|file|mimes:jpeg,jpg,png,webp|max:10240',
            'groom_child_order' => 'nullable|string|max:255',
            'bride_child_order' => 'nullable|string|max:255',
        ]);

        $uploadErrors = [];

        DB::transaction(function () use ($request, $invitation, &$uploadErrors) {
            $oldStories = is_string($invitation->love_story)
                ? json_decode($invitation->love_story, true)
                : $invitation->love_story;

            $oldStories = $oldStories ?? [];
            $stories = [];

            if ($request->has('love_story')) {
                foreach ($request->love_story as $index => $storyText) {

                    $photoPath = $oldStories[$index]['photo'] ?? null;

                    if ($request->hasFile('story_photo.'.$index)) {

                        if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                            Storage::disk('public')->delete($photoPath);
                        }

                        $photoPath = $this->uploadImageAsWebP(
                            $request->file('story_photo.'.$index),
                            "love_story/{$index}_".uniqid().'.webp'
                        );
                    }

                    $stories[] = [
                        'title' => $request->story_title[$index] ?? null,
                        'story' => $storyText,
                        'photo' => $photoPath,
                    ];
                }
            }

            $baseSlug = Str::slug($request->groom_name.'-'.$request->bride_name);
            $slug = $baseSlug;
            $counter = 1;
            while (Invitation::where('slug', $slug)->where('id', '!=', $invitation->id)->exists()) {
                $slug = $baseSlug.'-'.$counter;
                $counter++;
            }

            $updateData = [
                'template_id' => $request->template_id,
                'status' => 'published',
                'primary_color' => $request->primary_color,
                'slug' => $slug,

                'groom_name' => $request->groom_name,
                'groom_nickname' => $request->groom_nickname,
                'groom_father_name' => $request->groom_father_name,
                'groom_mother_name' => $request->groom_mother_name,
                'groom_child_order' => $request->groom_child_order,

                'bride_name' => $request->bride_name,
                'bride_nickname' => $request->bride_nickname,
                'bride_father_name' => $request->bride_father_name,
                'bride_mother_name' => $request->bride_mother_name,
                'bride_child_order' => $request->bride_child_order,

                'wedding_date' => $request->wedding_date,

                'akad_location' => $request->akad_location,
                'akad_time' => $request->akad_time,
                'akad_time_end' => $request->akad_time_end,
                'akad_maps' => $request->akad_maps,

                'resepsi_location' => $request->resepsi_location,
                'resepsi_time' => $request->resepsi_time,
                'resepsi_time_end' => $request->filled('sampai_selesai') ? 'Selesai' : $request->resepsi_time_end,
                'resepsi_maps' => $request->resepsi_maps,

                'theme_color' => $request->theme_color,
                'quote_id' => $request->quote_id,
                'wedding_quote' => $request->wedding_quote,
                'video_link' => $request->video_link,
                'youtube_url' => $request->youtube_url,
                'love_story' => $stories,

                'enable_rsvp' => $request->has('enable_rsvp'),
                'enable_gift' => $request->has('enable_gift'),

                'groom_instagram' => $request->groom_username_instagram ? 'https://www.instagram.com/'.$request->groom_username_instagram : $invitation->groom_instagram,
                'groom_username_instagram' => $request->groom_username_instagram,
                'bride_instagram' => $request->bride_username_instagram ? 'https://www.instagram.com/'.$request->bride_username_instagram : $invitation->bride_instagram,
                'bride_username_instagram' => $request->bride_username_instagram,
                'akad_address' => $request->akad_address,
                'resepsi_address' => $request->resepsi_address,

                'rsvp_deadline' => $request->rsvp_deadline,
                'rsvp_message' => $request->rsvp_message,
                'rsvp_whatsapp' => $request->rsvp_whatsapp,

                'music_youtube_url' => $request->music_youtube_url,
            ];

            $invitation->update($updateData);

            \Log::debug('Update foto debug', [
                'has_foto_pria' => $request->hasFile('foto_pria'),
                'has_foto_wanita' => $request->hasFile('foto_wanita'),
                'all_files' => array_keys($request->files->all()),
            ]);

            // --- REMOVE FOTO PRIA IF FLAGGED (only if no new file was uploaded) ---
            if ($request->input('remove_foto_pria') == 1 && ! $request->hasFile('foto_pria')) {
                if ($invitation->foto_pria) {
                    Storage::disk('public')->delete($invitation->foto_pria);
                }
                $invitation->update(['foto_pria' => null]);
            }

            // --- REMOVE FOTO WANITA IF FLAGGED (only if no new file was uploaded) ---
            if ($request->input('remove_foto_wanita') == 1 && ! $request->hasFile('foto_wanita')) {
                if ($invitation->foto_wanita) {
                    Storage::disk('public')->delete($invitation->foto_wanita);
                }
                $invitation->update(['foto_wanita' => null]);
            }

            // --- FOTO PRIA ---
            if ($request->hasFile('foto_pria')) {
                try {
                    $oldPath = $invitation->foto_pria;
                    $pathPria = "invitations/{$invitation->id}/pria/pria.webp";
                    $this->uploadImageAsWebP($request->file('foto_pria'), $pathPria, 1200);

                    if ($oldPath && $oldPath !== $pathPria) {
                        Storage::disk('public')->delete($oldPath);
                    }
                    $invitation->update(['foto_pria' => $pathPria]);
                } catch (\Throwable $e) {
                    \Log::error('Foto pria upload failed: '.$e->getMessage());
                    $uploadErrors[] = 'Foto mempelai pria: '.$e->getMessage();
                }
            }

            // --- FOTO WANITA ---
            if ($request->hasFile('foto_wanita')) {
                try {
                    $oldPath = $invitation->foto_wanita;
                    $pathWanita = "invitations/{$invitation->id}/wanita/wanita.webp";
                    $this->uploadImageAsWebP($request->file('foto_wanita'), $pathWanita, 1200);

                    if ($oldPath && $oldPath !== $pathWanita) {
                        Storage::disk('public')->delete($oldPath);
                    }
                    $invitation->update(['foto_wanita' => $pathWanita]);
                } catch (\Throwable $e) {
                    \Log::error('Foto wanita upload failed: '.$e->getMessage());
                    $uploadErrors[] = 'Foto mempelai wanita: '.$e->getMessage();
                }
            }

            // --- GALLERY COVER ---
            $removeCover = $request->input('remove_gallery_cover') == 1;
            $hasNewCover = $request->hasFile('gallery_cover');

            if ($removeCover && ! $hasNewCover) {
                if ($invitation->gallery_cover) {
                    Storage::disk('public')->delete($invitation->gallery_cover);
                }
                $invitation->update(['gallery_cover' => null]);
            }

            if ($hasNewCover) {
                try {
                    $oldPath = $invitation->gallery_cover;
                    $path = "invitations/{$invitation->id}/cover/cover.webp";
                    $this->uploadImageAsWebP($request->file('gallery_cover'), $path, 1600);

                    if ($oldPath && $oldPath !== $path) {
                        Storage::disk('public')->delete($oldPath);
                    }
                    $invitation->update(['gallery_cover' => $path]);
                } catch (\Throwable $e) {
                    \Log::error('Gallery cover upload failed: '.$e->getMessage());
                    $uploadErrors[] = 'Cover galeri: '.$e->getMessage();
                }
            }

            if ($request->input('music_source') === 'youtube') {
                $invitation->update([
                    'music_youtube_url' => $request->music_youtube_url,
                    'music' => 0,
                ]);
            } elseif ($request->hasFile('custom_music')) {
                if ($invitation->music) {
                    Storage::disk('public')->delete($invitation->music);
                }
                $musicPath = $request->file('custom_music')->store("invitations/{$invitation->id}/music", 'public');
                $invitation->update([
                    'music' => $musicPath,
                    'music_youtube_url' => null,
                ]);
            } else {
                $invitation->update([
                    'music' => $request->music_id,
                    'music_youtube_url' => null,
                ]);
            }

            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $index => $imageFile) {
                    try {
                        $folder = "invitations/{$invitation->id}/gallery";

                        if (! Storage::disk('public')->exists($folder)) {
                            Storage::disk('public')->makeDirectory($folder, 0755, true);
                        }

                        $path = $this->uploadImageAsWebP(
                            $imageFile,
                            $folder.'/'.uniqid().'.webp'
                        );

                        Gallery::create([
                            'invitation_id' => $invitation->id,
                            'image' => $path,
                        ]);
                    } catch (\Throwable $e) {
                        \Log::error('Gallery upload failed: '.$e->getMessage());
                        $uploadErrors[] = 'Galeri #'.($index + 1).': '.$e->getMessage();
                    }
                }
            }

            if ($request->enable_gift == 1) {

                $banks = $request->bank ?? [];
                $numbers = $request->number ?? [];
                $names = $request->name ?? [];
                $qrs = $request->file('qr') ?? [];

                foreach ($banks as $i => $bank) {

                    if (
                        empty($numbers[$i]) ||
                        empty($names[$i])
                    ) {
                        continue;
                    }

                    $data = [
                        'number' => $numbers[$i] ?? null,
                        'name' => $names[$i] ?? null,
                    ];

                    if (isset($qrs[$i])) {
                        try {
                            $data['qr'] = $this->uploadImageAsWebP(
                                $qrs[$i],
                                'gifts/'.uniqid().'.webp'
                            );
                        } catch (\Throwable $e) {
                            \Log::error('Gift QR upload failed: '.$e->getMessage());
                            $uploadErrors[] = 'QR Gift #'.($i + 1).': '.$e->getMessage();
                        }
                    }

                    Gift::updateOrCreate(
                        [
                            'invitation_id' => $invitation->id,
                            'bank' => $bank,
                        ],
                        $data
                    );
                }
            }

        });

        if (! empty($uploadErrors)) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data berhasil diperbarui, tetapi ada masalah pada upload gambar: '.implode(', ', $uploadErrors),
                ]);
            }

            return redirect()
                ->back()
                ->with('warning', 'Data berhasil diperbarui, tetapi ada masalah pada upload gambar: '.implode(', ', $uploadErrors));
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Undangan berhasil diperbarui',
                'invitation' => $invitation->fresh(),
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Undangan berhasil diperbarui 💖');
    }

    public function destroyGallery(Invitation $invitation, Request $request, $id)
    {
        $photo = Gallery::findOrFail($id);

        Storage::disk('public')->delete($photo->image);

        $photo->delete();

        return response()->json(['success' => true]);
    }

    public function detail($slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();
        $galleries = Gallery::where('invitation_id', $invitation->id)->get();

        return view('dashboard.invitation.detail', compact('invitation', 'galleries'));
    }

    public function autoSave(Request $request)
    {
        // Sangat santai: minimal template_id untuk bisa pratinjau
        $request->validate([
            'template_id' => 'required|exists:templates,id',
        ]);

        $user = auth()->user();
        // Check Template Access
        $template = Template::findOrFail($request->template_id);
        if (! $user->hasFeature('all_themes') && $template->slug !== 'simple-theme') {
            return redirect()->back()->with('error', 'Template ini hanya tersedia untuk paket berbayar. Upgrade untuk mengakses semua tema.');
        }

        $id = $request->id;
        $invitation = null;

        if ($id && $id != 0) {
            $invitation = Invitation::where('id', $id)->where('user_id', auth()->id())->first();
        }

        // Data yang akan disimpan (hanya teks/json, bukan file agar ringan)
        $data = $request->except(['foto_pria', 'foto_wanita', 'gallery_cover', 'gallery', 'custom_music', 'qr', 'story_photo']);
        $data['user_id'] = auth()->id();
        $data['status'] = 'draft';

        // Unique Slug for AutoSave
        $baseSlug = 'draft-'.auth()->id();
        if ($request->groom_name && $request->bride_name) {
            $baseSlug = Str::slug($request->groom_name.'-'.$request->bride_name);
        }

        $slug = $baseSlug;
        $counter = 1;
        $existingId = ($invitation) ? $invitation->id : 0;
        while (Invitation::where('slug', $slug)->where('id', '!=', $existingId)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }
        $data['slug'] = $slug;

        // Khusus fields boolean/checkbox
        $data['enable_rsvp'] = $request->has('enable_rsvp');
        $data['enable_gift'] = $request->has('enable_gift');

        if ($invitation) {
            // Jika sudah ada, jangan ganti slugnya terus menerus kalau sudah punya nama
            if ($invitation->groom_name && $invitation->bride_name && isset($data['slug'])) {
                unset($data['slug']);
            }
            $invitation->update($data);
        } else {
            $invitation = Invitation::create($data);
        }

        return response()->json([
            'success' => true,
            'id' => $invitation->id,
            'message' => 'Draft otomatis disimpan ✨',
        ]);
    }

    public function destroy(Invitation $invitation)
    {
        if ($invitation->is_default) {
            return redirect()
                ->back()
                ->with('error', 'Data default romeo-juliet tidak dapat dihapus.');
        }

        DB::transaction(function () use ($invitation) {
            // Hapus file-file terkait
            if ($invitation->foto_pria) {
                Storage::disk('public')->delete($invitation->foto_pria);
            }
            if ($invitation->foto_wanita) {
                Storage::disk('public')->delete($invitation->foto_wanita);
            }
            if ($invitation->gallery_cover) {
                Storage::disk('public')->delete($invitation->gallery_cover);
            }

            // Periksa apakah musik kustom atau ID musik
            if ($invitation->music && ! is_numeric($invitation->music)) {
                Storage::disk('public')->delete($invitation->music);
            }

            // Hapus galeri
            foreach ($invitation->galleries as $gallery) {
                Storage::disk('public')->delete($gallery->image);
                $gallery->delete();
            }

            // Hapus RSVP & Gift
            $invitation->gifts()->delete();
            $invitation->rsvps()->delete();

            $invitation->delete();
        });

        return redirect()->back()->with('success', 'Undangan berhasil dihapus 🗑️');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;
        if (! $ids || ! is_array($ids)) {
            return redirect()->back()->with('error', 'Pilih minimal satu undangan untuk dihapus.');
        }

        DB::transaction(function () use ($ids) {
            $invitations = Invitation::whereIn('id', $ids)->get();

            foreach ($invitations as $invitation) {
                // abort_if($invitation->user_id !== auth()->id() && !auth()->user()->hasRole('admin'), 403);

                // Hapus file-file terkait
                if ($invitation->foto_pria) {
                    Storage::disk('public')->delete($invitation->foto_pria);
                }
                if ($invitation->foto_wanita) {
                    Storage::disk('public')->delete($invitation->foto_wanita);
                }
                if ($invitation->gallery_cover) {
                    Storage::disk('public')->delete($invitation->gallery_cover);
                }

                if ($invitation->music && ! is_numeric($invitation->music)) {
                    Storage::disk('public')->delete($invitation->music);
                }

                foreach ($invitation->galleries as $gallery) {
                    Storage::disk('public')->delete($gallery->image);
                    $gallery->delete();
                }

                $invitation->gifts()->delete();
                $invitation->rsvps()->delete();
                $invitation->delete();
            }
        });

        return redirect()->back()->with('success', 'Undangan terpilih berhasil dihapus 🗑️');
    }

    public function upgradeToPremium(Request $request)
    {
        $user = auth()->user();

        // Buat subscription aktif selama 30 hari
        Subscription::updateOrCreate(
            ['user_id' => $user->id],
            [
                'subscription_plan_id' => 3, // Premium Plan
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'is_active' => true,
            ]
        );

        return redirect()->back()->with('success', 'Selamat! Anda telah berlangganan Paket Premium. Nikmati fitur buat undangan tanpa batas selama 30 hari ke depan! 💎✨');
    }
}
