<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Gift;
use App\Models\Invitation;
use App\Models\Music;
use App\Models\Subscription;
use App\Models\Template;
use App\Models\TemplateType;
use App\Models\User;
use App\Notifications\PartnerInvitationNotification;
use App\Services\ImageProcessingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

    private function imageDisk(): ImageProcessingService
    {
        return app(ImageProcessingService::class);
    }

    private function getInvitationLimit(User $user): ?int
    {
        if ($user->isAdmin()) {
            return null;
        }

        if ($user->subscription && $user->subscription->is_active && $user->subscription->end_date->isFuture()) {
            return (int) ($user->subscription->plan->invitation_limit ?? 1);
        }

        return 1;
    }

    public function index()
    {
        $query = Invitation::with('user');

        if (! auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $invitations = $query->orderByDesc('id')->get();

        return view('dashboard.invitation.index', compact('invitations'));
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        $limit = $this->getInvitationLimit($user);

        if ($limit !== null && Invitation::where('user_id', $user->id)->count() >= $limit) {
            $message = $limit === 1
                ? 'Versi gratis hanya diperbolehkan membuat 1 undangan. Silakan aktifkan Paket Subscription untuk membuat lebih banyak! ✨'
                : "Paket Anda hanya diperbolehkan membuat {$limit} undangan. Silakan upgrade paket untuk membuat lebih banyak! ✨";
            return redirect()->route('dashboard.user')->with('error', $message);
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
            'theme_type' => 'nullable|string|in:basic,premium_exclusive,luxury',
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
        $limit = $this->getInvitationLimit($user);

        if ($limit !== null && Invitation::where('user_id', $user->id)->count() >= $limit) {
            $message = $limit === 1
                ? 'Anda hanya dapat membuat satu undangan. Upgrade ke berlangganan untuk membuat undangan tanpa batas.'
                : "Paket Anda hanya diperbolehkan membuat {$limit} undangan. Upgrade paket untuk membuat lebih banyak.";
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 403);
            }

            return redirect()
                ->back()
                ->with('error', $message);
        }

        $templateId = $request->template_id ?? 2;

        $invitation = Invitation::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'slug' => $slug,
            ],
            [
                'template_id' => $templateId,
                'theme_type' => $request->theme_type,
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
        $filename = pathinfo($fullPath, PATHINFO_FILENAME);

        $result = app(ImageProcessingService::class)->process($file, $folder, $filename, $maxWidth);

        \Log::debug('uploadImageAsWebP saved', [
            'path' => $result['path'],
            'url' => $result['url'],
            'size' => $result['size'],
        ]);

        return $result['path'];
    }

    public function store(Request $request)
    {
        $request->validate([
            'bride_name' => 'required|string|max:255',
            'groom_name' => 'required|string|max:255',
            'wedding_date' => 'nullable|date',
            'template_id' => 'required|exists:templates,id',
            'theme_type' => 'nullable|string|in:basic,premium_exclusive,luxury',
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

        $baseSlug = Str::slug(
            ($request->groom_nickname ?: $request->groom_name).'-'.($request->bride_nickname ?: $request->bride_name)
        );

        $user = auth()->user();

        if ($request->filled('id')) {
            $existingById = Invitation::where('id', $request->id)
                ->where('user_id', $user->id)
                ->first();

            if ($existingById) {
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Undangan sudah ada, redirecting to edit mode',
                        'invitation' => $existingById,
                        'redirect_to_edit' => true,
                    ]);
                }

                return redirect()
                    ->route('invitation.update', $existingById)
                    ->withInput()
                    ->with('info', 'Undangan sudah ada, Anda dialihkan ke halaman edit.');
            }
        }

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

        // Gallery toggle is now available to all authenticated users

        // Check Music toggle
        if ($request->has('enable_music') && $request->enable_music && ! $user->hasFeature('background_music') && ! $user->hasFeature('custom_music')) {
            return redirect()->back()->with('error', 'Fitur Musik Latar hanya tersedia untuk paket berbayar.');
        }

        // Check Video toggle
        if ($request->has('enable_video') && $request->enable_video && ! $user->hasFeature('streaming_video')) {
            return redirect()->back()->with('error', 'Fitur Link Video hanya tersedia untuk paket berbayar.');
        }

        // Check Love Story toggle
        if ($request->has('enable_love_story') && $request->enable_love_story && ! $user->hasFeature('love_story')) {
            return redirect()->back()->with('error', 'Fitur Kisah Cinta hanya tersedia untuk paket berbayar.');
        }

        // Gallery feature check removed - now available to all users with invitation access

        $galleryLimit = null;
        if ($user->subscription) {
            $galleryLimit = data_get($user->subscription->plan->features ?? [], 'gallery_limit');
        } else {
            $partnerOwner = $user->getPartnerSubscriptionOwner();
            if ($partnerOwner && $partnerOwner->subscription) {
                $galleryLimit = data_get($partnerOwner->subscription->plan->features ?? [], 'gallery_limit');
            }
        }
        if ($request->hasFile('gallery') && ! is_null($galleryLimit) && $galleryLimit > 0 && count($request->file('gallery')) > $galleryLimit) {
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

            if ($request->has('enable_love_story') && $request->enable_love_story) {
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
            }
            $baseSlug = Str::slug(
                ($request->groom_nickname ?: $request->groom_name).'-'.($request->bride_nickname ?: $request->bride_name)
            );
            $slug = $baseSlug;
            $counter = 1;
            while (Invitation::where('slug', $slug)->exists()) {
                $slug = $baseSlug.'-'.$counter;
                $counter++;
            }

            $invitation = Invitation::create([
                'user_id' => auth()->user()->id,
                'template_id' => $request->template_id,
                'theme_type' => $request->theme_type,
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

                'enable_rsvp' => $request->has('enable_rsvp'),
                'enable_gift' => $request->has('enable_gift'),
                'enable_gallery' => $request->has('enable_gallery'),
                'enable_music' => $request->has('enable_music'),
                'enable_video' => $request->has('enable_video'),
                'enable_love_story' => $request->has('enable_love_story'),

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

            if ($request->has('enable_video') && $request->enable_video) {
                $invitation->update([
                    'video_link' => $request->video_link,
                    'youtube_url' => $request->youtube_url,
                ]);
            }

            $invitation->update(['love_story' => $stories]);
            if ($request->hasFile('foto_pria')) {
                try {
                    $path = "invitations/{$invitation->public_id}/pria/pria.webp";

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
                    $path = "invitations/{$invitation->public_id}/wanita/wanita.webp";

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
                    $path = "invitations/{$invitation->public_id}/cover/cover.webp";

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

            if ($request->has('enable_music') && $request->enable_music) {
                if ($request->hasFile('custom_music')) {
                    $musicPath = $request->file('custom_music')
                        ->store("invitations/{$invitation->public_id}/music", 'public');

                    $invitation->update(['music' => $musicPath]);
                } else {
                    $invitation->update([
                        'music' => $request->music_id,
                    ]);
                }
            }

            if ($request->has('enable_gallery') && $request->enable_gallery && $request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $index => $imageFile) {
                    try {
                        $folder = "invitations/{$invitation->public_id}/gallery";

                        if (! $this->imageDisk()->exists($folder)) {
                            $this->imageDisk()->ensureDirectory($folder);
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
        $user = auth()->user();

        if (! $user->canAccessInvitation($invitation)) {
            abort(403, 'Anda tidak memiliki akses ke undangan ini.');
        }

        if ($user->id === $invitation->partner_user_id && ! $invitation->partner_can_edit) {
            abort(403, 'Anda hanya memiliki akses melihat undangan ini.');
        }

        $invitation->load('user.subscription.plan');

        $music = Music::where('is_active', true)->get();
        $templates = Template::where('is_active', true)->with('category', 'templateType')->get();
        $templateTypes = TemplateType::orderBy('name')->get();

        return view('dashboard.invitation.edit', compact('invitation', 'music', 'templates', 'templateTypes'));
    }

    public function update(Request $request, Invitation $invitation)
    {
        $user = auth()->user();

        if (! $user->canAccessInvitation($invitation)) {
            abort(403, 'Anda tidak memiliki akses ke undangan ini.');
        }

        if ($user->id === $invitation->partner_user_id && ! $invitation->partner_can_edit) {
            abort(403, 'Anda hanya memiliki akses melihat undangan ini.');
        }

        // Check Template Access
        $template = Template::findOrFail($request->template_id);
        if (! $user->hasFeature('all_themes') && $template->slug !== 'simple-theme') {
            return redirect()->back()->with('error', 'Template ini hanya tersedia untuk paket berbayar. Upgrade untuk mengakses semua tema.');
        }

        // Check RSVP feature
        if ($request->has('enable_rsvp') && ! $user->hasFeature('rsvp_messages')) {
            return redirect()->back()->with('error', 'Fitur RSVP hanya tersedia untuk paket berbayar.');
        }

        // Gallery toggle is now available to all authenticated users
        // (previously gated by hasFeature('gallery') which blocked free-tier users)

        // Check Music toggle
        if ($request->has('enable_music') && $request->enable_music && ! $user->hasFeature('background_music') && ! $user->hasFeature('custom_music')) {
            return redirect()->back()->with('error', 'Fitur Musik Latar hanya tersedia untuk paket berbayar.');
        }

        // Check Video toggle
        if ($request->has('enable_video') && $request->enable_video && ! $user->hasFeature('streaming_video')) {
            return redirect()->back()->with('error', 'Fitur Link Video hanya tersedia untuk paket berbayar.');
        }

        // Check Love Story toggle
        if ($request->has('enable_love_story') && $request->enable_love_story && ! $user->hasFeature('love_story')) {
            return redirect()->back()->with('error', 'Fitur Kisah Cinta hanya tersedia untuk paket berbayar.');
        }

        // Check Gallery feature (now available to all users with invitation access)
        $galleryLimit = null;
        if ($invitation->user && $invitation->user->subscription) {
            $galleryLimit = data_get($invitation->user->subscription->plan->features ?? [], 'gallery_limit');
        } elseif ($user->subscription) {
            $galleryLimit = data_get($user->subscription->plan->features ?? [], 'gallery_limit');
        }
        $currentGalleryCount = $invitation->galleries()->count();
        $newGalleryCount = $request->hasFile('gallery') ? count($request->file('gallery')) : 0;
        if (! is_null($galleryLimit) && $galleryLimit > 0 && ($currentGalleryCount + $newGalleryCount) > $galleryLimit) {
            return redirect()->back()->with('error', "Maksimal {$galleryLimit} foto untuk paket ini. Anda sudah memiliki {$currentGalleryCount} foto.");
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
            'wedding_date' => 'nullable|date',
            'template_id' => 'required|exists:templates,id',
            'theme_type' => 'nullable|string|in:basic,premium_exclusive,luxury',
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

        // ============================================
        // STEP 1: Save text data in transaction
        // ============================================
        DB::transaction(function () use ($request, $invitation) {
            $oldStories = is_string($invitation->love_story)
                ? json_decode($invitation->love_story, true)
                : $invitation->love_story;

            $oldStories = $oldStories ?? [];
            $stories = [];

            if ($request->has('enable_love_story') && $request->enable_love_story) {
                if ($request->has('love_story')) {
                    foreach ($request->love_story as $index => $storyText) {
                        $photoPath = $oldStories[$index]['photo'] ?? null;

                        $stories[] = [
                            'title' => $request->story_title[$index] ?? null,
                            'story' => $storyText,
                            'photo' => $photoPath,
                        ];
                    }
                }
            }

            $baseSlug = Str::slug(
                ($request->groom_nickname ?: $request->groom_name).'-'.($request->bride_nickname ?: $request->bride_name)
            );
            $slug = $baseSlug;
            $counter = 1;
            while (Invitation::where('slug', $slug)->where('id', '!=', $invitation->id)->exists()) {
                $slug = $baseSlug.'-'.$counter;
                $counter++;
            }

            $updateData = [
                'template_id' => $request->template_id,
                'theme_type' => $request->theme_type,
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

                'enable_rsvp' => $request->has('enable_rsvp'),
                'enable_gift' => $request->has('enable_gift'),
                'enable_gallery' => $request->has('enable_gallery'),
                'enable_music' => $request->has('enable_music'),
                'enable_video' => $request->has('enable_video'),
                'enable_love_story' => $request->has('enable_love_story'),

                'groom_instagram' => $request->groom_username_instagram ? 'https://www.instagram.com/'.$request->groom_username_instagram : $invitation->groom_instagram,
                'groom_username_instagram' => $request->groom_username_instagram,
                'bride_instagram' => $request->bride_instagram,
                'bride_username_instagram' => $request->bride_username_instagram,
                'akad_address' => $request->akad_address,
                'resepsi_address' => $request->resepsi_address,

                'rsvp_deadline' => $request->rsvp_deadline,
                'rsvp_message' => $request->rsvp_message,
                'rsvp_whatsapp' => $request->rsvp_whatsapp,

                'music_youtube_url' => $request->music_youtube_url,
            ];

            if ($request->has('enable_video') && $request->enable_video) {
                $updateData['video_link'] = $request->video_link;
                $updateData['youtube_url'] = $request->youtube_url;
            }

            $updateData['love_story'] = $stories;

            $invitation->update($updateData);
        });

        // ============================================
        // STEP 2: Handle file uploads OUTSIDE transaction
        // ============================================

        // --- REMOVE FOTO PRIA IF FLAGGED ---
        if ($request->input('remove_foto_pria') == 1 && ! $request->hasFile('foto_pria')) {
            if ($invitation->foto_pria) {
                $this->imageDisk()->delete($invitation->foto_pria);
            }
            $invitation->update(['foto_pria' => null]);
        }

        // --- REMOVE FOTO WANITA IF FLAGGED ---
        if ($request->input('remove_foto_wanita') == 1 && ! $request->hasFile('foto_wanita')) {
            if ($invitation->foto_wanita) {
                $this->imageDisk()->delete($invitation->foto_wanita);
            }
            $invitation->update(['foto_wanita' => null]);
        }

        // --- FOTO PRIA ---
        if ($request->hasFile('foto_pria')) {
            try {
                $oldPath = $invitation->foto_pria;
                $pathPria = "invitations/{$invitation->public_id}/pria/pria.webp";
                $this->uploadImageAsWebP($request->file('foto_pria'), $pathPria, 1200);

                if ($oldPath && $oldPath !== $pathPria) {
                    $this->imageDisk()->delete($oldPath);
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
                $pathWanita = "invitations/{$invitation->public_id}/wanita/wanita.webp";
                $this->uploadImageAsWebP($request->file('foto_wanita'), $pathWanita, 1200);

                if ($oldPath && $oldPath !== $pathWanita) {
                    $this->imageDisk()->delete($oldPath);
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
                $this->imageDisk()->delete($invitation->gallery_cover);
            }
            $invitation->update(['gallery_cover' => null]);
        }

        if ($hasNewCover) {
            try {
                $oldPath = $invitation->gallery_cover;
                $path = "invitations/{$invitation->public_id}/cover/cover.webp";
                $this->uploadImageAsWebP($request->file('gallery_cover'), $path, 1600);

                if ($oldPath && $oldPath !== $path) {
                    $this->imageDisk()->delete($oldPath);
                }
                $invitation->update(['gallery_cover' => $path]);
            } catch (\Throwable $e) {
                \Log::error('Gallery cover upload failed: '.$e->getMessage());
                $uploadErrors[] = 'Cover galeri: '.$e->getMessage();
            }
        }

        // --- CUSTOM MUSIC ---
        if ($request->has('enable_music') && $request->enable_music) {
            if ($request->input('music_source') === 'youtube') {
                $invitation->update([
                    'music_youtube_url' => $request->music_youtube_url,
                    'music' => 0,
                ]);
            } elseif ($request->hasFile('custom_music')) {
                if ($invitation->music) {
                    Storage::disk('public')->delete($invitation->music);
                }
                $musicPath = $request->file('custom_music')->store("invitations/{$invitation->public_id}/music", 'public');
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
        }

        // --- LOVE STORY PHOTOS ---
        if ($request->has('enable_love_story') && $request->enable_love_story && $request->has('love_story')) {
            $oldStories = is_string($invitation->love_story)
                ? json_decode($invitation->love_story, true)
                : $invitation->love_story;
            $oldStories = $oldStories ?? [];
            $stories = [];

            $importedLoveStoryPhotos = $request->input('imported_love_story_photos', []);

            foreach ($request->love_story as $index => $storyText) {
                $photoPath = $oldStories[$index]['photo'] ?? null;

                if ($request->hasFile('story_photo.'.$index)) {
                    try {
                        if ($photoPath && $this->imageDisk()->exists($photoPath)) {
                            $this->imageDisk()->delete($photoPath);
                        }

                        $photoPath = $this->uploadImageAsWebP(
                            $request->file('story_photo.'.$index),
                            "love_story/{$index}_".uniqid().'.webp'
                        );
                    } catch (\Throwable $e) {
                        \Log::error('Love story photo upload failed: '.$e->getMessage());
                        $uploadErrors[] = 'Foto kisah #'.($index + 1).': '.$e->getMessage();
                    }
                } elseif (isset($importedLoveStoryPhotos[$index]) && !empty($importedLoveStoryPhotos[$index])) {
                    $photoPath = $importedLoveStoryPhotos[$index];
                }

                $stories[] = [
                    'title' => $request->story_title[$index] ?? null,
                    'story' => $storyText,
                    'photo' => $photoPath,
                ];
            }

            $invitation->update(['love_story' => $stories]);
        }

        // --- GALLERY ---
        if ($request->has('enable_gallery') && $request->enable_gallery && $request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $imageFile) {
                try {
                    $folder = "invitations/{$invitation->public_id}/gallery";

                    if (! $this->imageDisk()->exists($folder)) {
                        $this->imageDisk()->ensureDirectory($folder);
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

        // --- GIFT QR ---
        if ($request->enable_gift == 1) {
            $banks = $request->bank ?? [];
            $numbers = $request->number ?? [];
            $names = $request->name ?? [];
            $qrs = $request->file('qr') ?? [];

            foreach ($banks as $i => $bank) {
                if (empty($numbers[$i]) || empty($names[$i])) {
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

        $this->imageDisk()->delete($photo->image);

        $photo->delete();

        return response()->json(['success' => true]);
    }

    public function uploadGallery(Request $request, Invitation $invitation)
    {
        $user = auth()->user();

        if (! $user->canAccessInvitation($invitation)) {
            abort(403, 'Anda tidak memiliki akses ke undangan ini.');
        }

        if ($user->id === $invitation->partner_user_id && ! $invitation->partner_can_edit) {
            abort(403, 'Anda hanya memiliki akses melihat undangan ini.');
        }

        $galleryLimit = null;
        if ($invitation->user && $invitation->user->subscription) {
            $galleryLimit = data_get($invitation->user->subscription->plan->features ?? [], 'gallery_limit');
        } elseif ($user->subscription) {
            $galleryLimit = data_get($user->subscription->plan->features ?? [], 'gallery_limit');
        }
        if (! is_null($galleryLimit) && $galleryLimit > 0 && $invitation->galleries()->count() >= $galleryLimit) {
            return response()->json(['success' => false, 'message' => "Maksimal {$galleryLimit} foto untuk paket ini."], 403);
        }

        $request->validate([
            'image' => 'required|file|mimes:jpeg,jpg,png,gif,webp|max:10240',
        ]);

        try {
            $folder = "invitations/{$invitation->public_id}/gallery";

            if (! $this->imageDisk()->exists($folder)) {
                $this->imageDisk()->ensureDirectory($folder);
            }

            $path = $this->uploadImageAsWebP(
                $request->file('image'),
                $folder.'/'.uniqid().'.webp'
            );

            $gallery = Gallery::create([
                'invitation_id' => $invitation->id,
                'image' => $path,
            ]);

            return response()->json([
                'success' => true,
                'gallery' => $gallery,
                'url' => storage_url($path, $invitation->updated_at->timestamp),
            ]);
        } catch (\Throwable $e) {
            \Log::error('Gallery upload failed: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function uploadCover(Request $request, Invitation $invitation)
    {
        $user = auth()->user();

        if (! $user->canAccessInvitation($invitation)) {
            abort(403, 'Anda tidak memiliki akses ke undangan ini.');
        }

        if ($user->id === $invitation->partner_user_id && ! $invitation->partner_can_edit) {
            abort(403, 'Anda hanya memiliki akses melihat undangan ini.');
        }

        $request->validate([
            'cover' => 'required|file|mimes:jpeg,jpg,png,webp|max:10240',
        ]);

        try {
            $oldPath = $invitation->gallery_cover;
            $path = "invitations/{$invitation->public_id}/cover/cover.webp";

            $this->uploadImageAsWebP($request->file('cover'), $path, 1600);

            if ($oldPath && $oldPath !== $path) {
                $this->imageDisk()->delete($oldPath);
            }

            $invitation->update(['gallery_cover' => $path]);

            return response()->json([
                'success' => true,
                'url' => storage_url($path, $invitation->updated_at->timestamp),
                'path' => $path,
            ]);
        } catch (\Throwable $e) {
            \Log::error('Cover upload failed: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function uploadGroomPhoto(Request $request, Invitation $invitation)
    {
        $user = auth()->user();

        if (! $user->canAccessInvitation($invitation)) {
            abort(403, 'Anda tidak memiliki akses ke undangan ini.');
        }

        if ($user->id === $invitation->partner_user_id && ! $invitation->partner_can_edit) {
            abort(403, 'Anda hanya memiliki akses melihat undangan ini.');
        }

        $request->validate([
            'photo' => 'required|file|mimes:jpeg,jpg,png,webp|max:10240',
        ]);

        try {
            $oldPath = $invitation->foto_pria;
            $path = "invitations/{$invitation->public_id}/pria/pria.webp";

            $this->uploadImageAsWebP($request->file('photo'), $path, 1200);

            if ($oldPath && $oldPath !== $path) {
                $this->imageDisk()->delete($oldPath);
            }

            $invitation->update(['foto_pria' => $path]);

            return response()->json([
                'success' => true,
                'url' => storage_url($path, $invitation->updated_at->timestamp),
                'path' => $path,
            ]);
        } catch (\Throwable $e) {
            \Log::error('Groom photo upload failed: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function uploadBridePhoto(Request $request, Invitation $invitation)
    {
        $user = auth()->user();

        if (! $user->canAccessInvitation($invitation)) {
            abort(403, 'Anda tidak memiliki akses ke undangan ini.');
        }

        if ($user->id === $invitation->partner_user_id && ! $invitation->partner_can_edit) {
            abort(403, 'Anda hanya memiliki akses melihat undangan ini.');
        }

        $request->validate([
            'photo' => 'required|file|mimes:jpeg,jpg,png,webp|max:10240',
        ]);

        try {
            $oldPath = $invitation->foto_wanita;
            $path = "invitations/{$invitation->public_id}/wanita/wanita.webp";

            $this->uploadImageAsWebP($request->file('photo'), $path, 1200);

            if ($oldPath && $oldPath !== $path) {
                $this->imageDisk()->delete($oldPath);
            }

            $invitation->update(['foto_wanita' => $path]);

            return response()->json([
                'success' => true,
                'url' => storage_url($path, $invitation->updated_at->timestamp),
                'path' => $path,
            ]);
        } catch (\Throwable $e) {
            \Log::error('Bride photo upload failed: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function detail($slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();
        $galleries = Gallery::where('invitation_id', $invitation->id)->get();

        return view('dashboard.invitation.detail', compact('invitation', 'galleries'));
    }

    public function autoSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template_id' => 'required|exists:templates,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Template belum dipilih atau tidak valid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = auth()->user();
        // Check Template Access
        $template = Template::find($request->template_id);
        if (! $template) {
            return response()->json([
                'success' => false,
                'message' => 'Template tidak ditemukan.',
            ], 404);
        }

        if (! $user->hasFeature('all_themes') && $template->slug !== 'simple-theme') {
            return response()->json([
                'success' => false,
                'message' => 'Template ini hanya tersedia untuk paket berbayar. Upgrade untuk mengakses semua tema.',
            ], 403);
        }

        $id = $request->id;
        $invitation = null;

        if ($id && $id != 0) {
            $invitation = Invitation::where('id', $id)->first();

            if (! $invitation || ! auth()->user()->canAccessInvitation($invitation)) {
                abort(403, 'Anda tidak memiliki akses ke undangan ini.');
            }

            if (auth()->user()->id === $invitation->partner_user_id && ! $invitation->partner_can_edit) {
                abort(403, 'Anda hanya memiliki akses melihat undangan ini.');
            }
        }

        // Data yang akan disimpan (hanya teks/json, bukan file agar ringan)
        $data = $request->except(['foto_pria', 'foto_wanita', 'gallery_cover', 'gallery', 'custom_music', 'qr', 'story_photo', 'love_story', 'story_title', 'music_source', 'searchTemplate', 'categorySelect', 'typeSelect', 'uploaded_gallery_ids']);
        $data['user_id'] = auth()->id();
        $data['status'] = 'draft';

        // --- MUSIC SOURCE HANDLING (AUTOSAVE) ---
        if ($request->has('enable_music') && $request->enable_music) {
            $musicSource = $request->input('music_source', 'library');
            if ($musicSource === 'youtube') {
                $data['music'] = 0;
                $data['music_youtube_url'] = $request->input('music_youtube_url');
            } elseif ($musicSource === 'upload') {
                $data['music'] = $request->input('music_id');
                $data['music_youtube_url'] = null;
            } else {
                $data['music'] = $request->input('music_id');
                $data['music_youtube_url'] = null;
            }
        }

        // Proses love_story agar tersimpan dalam format yang benar
        if ($request->has('enable_love_story') && $request->enable_love_story) {
            $oldStories = [];
            if ($invitation) {
                $oldStories = is_string($invitation->love_story)
                    ? json_decode($invitation->love_story, true)
                    : $invitation->love_story;
                $oldStories = $oldStories ?? [];
            }

            $stories = [];
            if ($request->has('love_story')) {
                $importedLoveStoryPhotos = $request->input('imported_love_story_photos', []);
                foreach ($request->love_story as $index => $storyText) {
                    $photoPath = $oldStories[$index]['photo'] ?? null;

                    if ($request->hasFile('story_photo.'.$index)) {
                        try {
                            if ($photoPath && $this->imageDisk()->exists($photoPath)) {
                                $this->imageDisk()->delete($photoPath);
                            }

                            $photoPath = $this->uploadImageAsWebP(
                                $request->file('story_photo.'.$index),
                                "love_story/{$index}_".uniqid().'.webp'
                            );
                        } catch (\Throwable $e) {
                            \Log::error('Love story photo upload failed: '.$e->getMessage());
                            $uploadErrors[] = 'Foto kisah #'.($index + 1).': '.$e->getMessage();
                        }
                    } elseif (isset($importedLoveStoryPhotos[$index]) && !empty($importedLoveStoryPhotos[$index])) {
                        $photoPath = $importedLoveStoryPhotos[$index];
                    }

                    $stories[] = [
                        'title' => $request->story_title[$index] ?? null,
                        'story' => $storyText,
                        'photo' => $photoPath,
                    ];
                }
            }
            $data['love_story'] = $stories;
        } else {
            $data['love_story'] = [];
        }

        // Unique Slug for AutoSave
        $baseSlug = 'draft-'.auth()->id();
        if ($request->groom_name && $request->bride_name) {
            $baseSlug = Str::slug(
                ($request->groom_nickname ?: $request->groom_name).'-'.($request->bride_nickname ?: $request->bride_name)
            );
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
        $data['enable_gallery'] = $request->has('enable_gallery');
        $data['enable_music'] = $request->has('enable_music');
        $data['enable_video'] = $request->has('enable_video');
        $data['enable_love_story'] = $request->has('enable_love_story');

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
                $this->imageDisk()->delete($invitation->foto_pria);
            }
            if ($invitation->foto_wanita) {
                $this->imageDisk()->delete($invitation->foto_wanita);
            }
            if ($invitation->gallery_cover) {
                $this->imageDisk()->delete($invitation->gallery_cover);
            }

            // Periksa apakah musik kustom atau ID musik
            if ($invitation->music && ! is_numeric($invitation->music)) {
                Storage::disk('public')->delete($invitation->music);
            }

            // Hapus galeri
            foreach ($invitation->galleries as $gallery) {
                $this->imageDisk()->delete($gallery->image);
                $gallery->delete();
            }

            // Hapus seluruh folder invitation di storage/R2
            $folder = "invitations/{$invitation->public_id}";
            Storage::disk(config('image.disk', 'public'))->deleteDirectory($folder);

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
            $invitations = Invitation::whereIn('public_id', $ids)->get();

            foreach ($invitations as $invitation) {
                // abort_if($invitation->user_id !== auth()->id() && !auth()->user()->hasRole('admin'), 403);

                // Hapus file-file terkait
                if ($invitation->foto_pria) {
                    $this->imageDisk()->delete($invitation->foto_pria);
                }
                if ($invitation->foto_wanita) {
                    $this->imageDisk()->delete($invitation->foto_wanita);
                }
                if ($invitation->gallery_cover) {
                    $this->imageDisk()->delete($invitation->gallery_cover);
                }

                if ($invitation->music && ! is_numeric($invitation->music)) {
                    Storage::disk('public')->delete($invitation->music);
                }

                foreach ($invitation->galleries as $gallery) {
                    $this->imageDisk()->delete($gallery->image);
                    $gallery->delete();
                }

                // Hapus seluruh folder invitation di storage/R2
                $folder = "invitations/{$invitation->public_id}";
                Storage::disk(config('image.disk', 'public'))->deleteDirectory($folder);

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

    public function invitePartner(Request $request, Invitation $invitation)
    {
        $user = $request->user();

        abort_if($invitation->user_id !== $user->id && ! $user->isAdmin(), 403);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'can_edit' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format email tidak valid.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $partner = User::where('email', $request->email)->first();

        if (! $partner) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email ('.$request->email.') belum terdaftar. Minta pasangan Anda untuk mendaftar akun terlebih dahulu.',
                ], 422);
            }

            return redirect()->back()->with('error', 'Email pasangan belum terdaftar.');
        }

        if ($partner->id === $user->id) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak bisa mengundang akun Anda sendiri sebagai pasangan.',
                ], 422);
            }

            return redirect()->back()->with('error', 'Tidak bisa mengundang diri sendiri.');
        }

        $token = Str::random(64);
        $canEdit = (bool) $request->boolean('can_edit');

        $invitation->update([
            'partner_user_id' => $partner->id,
            'partner_invite_token' => $token,
            'partner_can_edit' => $canEdit,
            'partner_accepted_at' => null,
        ]);

        // Send Partner Invitation Email Notification
        try {
            $partner->notify(new PartnerInvitationNotification($invitation, $user, $token, $canEdit));
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim email undangan pasangan: '.$e->getMessage());
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Undangan pasangan dan email pemberitahuan berhasil dikirim ke '.$partner->email.'! 💌✨',
            ]);
        }

        return redirect()->back()->with('success', 'Undangan pasangan berhasil dikirim ke '.$partner->email.'! 💌✨');
    }

    public function acceptPartner($token)
    {
        $invitation = Invitation::where('partner_invite_token', $token)
            ->whereNotNull('partner_user_id')
            ->firstOrFail();

        if ($invitation->partner_accepted_at !== null) {
            return view('partner.already-accepted', compact('invitation'));
        }

        $invitation->update([
            'partner_accepted_at' => now(),
        ]);

        return redirect()->route('dashboard.user')->with('success', 'Undangan pasangan berhasil diterima! Anda sekarang dapat mengakses undangan ini. 🎉');
    }

    public function acceptPartnerDirect(Request $request, Invitation $invitation)
    {
        $user = $request->user();

        abort_if($invitation->partner_user_id !== $user->id, 403, 'Anda tidak diundang sebagai pasangan undangan ini.');

        if ($invitation->partner_accepted_at !== null) {
            return view('partner.already-accepted', compact('invitation'));
        }

        $invitation->update([
            'partner_accepted_at' => now(),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Undangan pasangan berhasil diterima! Anda sekarang dapat mengakses undangan ini. 🎉',
            ]);
        }

        return redirect()->back()->with('success', 'Undangan pasangan berhasil diterima! Anda sekarang dapat mengakses undangan ini. 🎉');
    }

    public function removePartner(Request $request, Invitation $invitation)
    {
        $user = $request->user();

        abort_if($invitation->user_id !== $user->id && ! $user->isAdmin(), 403);

        $invitation->update([
            'partner_user_id' => null,
            'partner_invite_token' => null,
            'partner_accepted_at' => null,
            'partner_can_edit' => false,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pasangan berhasil dihapus dari undangan.',
            ]);
        }

        return redirect()->back()->with('success', 'Pasangan berhasil dihapus dari undangan.');
    }

    public function searchPixabay(Request $request)
    {
        $query = $request->get('q', 'wedding');
        $page = (int) $request->get('page', 1);
        $apiKey = config('services.pixabay.key') ?: env('PIXABAY_API_KEY');

        if (! $apiKey) {
            \Log::error('Pixabay API key is missing. Set PIXABAY_API_KEY in .env');
            return response()->json(['hits' => [], 'error' => 'API key Pixabay belum dikonfigurasi.'], 500);
        }

        $url = 'https://pixabay.com/api/?key=' . $apiKey . '&q=' . urlencode($query) . '&image_type=photo&orientation=all&safesearch=true&per_page=20&page=' . $page;

        try {
            $response = Http::timeout(15)->get($url);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            \Log::error('Pixabay API error: HTTP ' . $response->status() . ' - ' . $response->body());
            return response()->json(['hits' => [], 'error' => 'Pixabay API error: HTTP ' . $response->status()], $response->status());
        } catch (\Throwable $e) {
            \Log::error('Pixabay search failed: '.$e->getMessage());
            return response()->json(['hits' => [], 'error' => 'Gagal terhubung ke Pixabay: '.$e->getMessage()], 500);
        }
    }

    public function importPixabayImage(Request $request, Invitation $invitation)
    {
        $request->validate([
            'image_url' => 'required|url',
            'type' => 'required|in:gallery,cover,groom,bride,love_story',
        ]);

        $user = auth()->user();

        if (! $user->canAccessInvitation($invitation)) {
            abort(403, 'Anda tidak memiliki akses ke undangan ini.');
        }

        if ($user->id === $invitation->partner_user_id && ! $invitation->partner_can_edit) {
            abort(403, 'Anda hanya memiliki akses melihat undangan ini.');
        }

        $type = $request->input('type');

        try {
            $imageResponse = Http::timeout(30)->get($request->input('image_url'));

            if (! $imageResponse->successful()) {
                return response()->json(['success' => false, 'message' => 'Gagal mengunduh gambar dari Pixabay.'], 500);
            }

            $tempPath = tempnam(sys_get_temp_dir(), 'pixabay_') . '.jpg';
            file_put_contents($tempPath, $imageResponse->body());

            $file = new \Illuminate\Http\UploadedFile(
                $tempPath,
                'pixabay_image.jpg',
                $imageResponse->header('Content-Type', 'image/jpeg'),
                null,
                true
            );

            if ($type === 'gallery') {
                $galleryLimit = null;
                if ($invitation->user && $invitation->user->subscription) {
                    $galleryLimit = data_get($invitation->user->subscription->plan->features ?? [], 'gallery_limit');
                } elseif ($user->subscription) {
                    $galleryLimit = data_get($user->subscription->plan->features ?? [], 'gallery_limit');
                }
                if (! is_null($galleryLimit) && $galleryLimit > 0 && $invitation->galleries()->count() >= $galleryLimit) {
                    @unlink($tempPath);
                    return response()->json(['success' => false, 'message' => "Maksimal {$galleryLimit} foto untuk paket ini."], 403);
                }

                $folder = "invitations/{$invitation->public_id}/gallery";

                if (! $this->imageDisk()->exists($folder)) {
                    $this->imageDisk()->ensureDirectory($folder);
                }

                $path = $this->uploadImageAsWebP($file, $folder.'/'.uniqid().'.webp');

                $gallery = Gallery::create([
                    'invitation_id' => $invitation->id,
                    'image' => $path,
                ]);

                @unlink($tempPath);

                return response()->json([
                    'success' => true,
                    'gallery' => $gallery,
                    'url' => storage_url($path, $invitation->updated_at->timestamp),
                ]);
            }

            if ($type === 'love_story') {
                $folder = "invitations/{$invitation->public_id}/love_story";

                if (! $this->imageDisk()->exists($folder)) {
                    $this->imageDisk()->ensureDirectory($folder);
                }

                $path = $this->uploadImageAsWebP($file, $folder.'/'.uniqid().'.webp');

                @unlink($tempPath);

                return response()->json([
                    'success' => true,
                    'url' => storage_url($path, $invitation->updated_at->timestamp),
                    'path' => $path,
                ]);
            }

            if ($type === 'cover') {
                $oldPath = $invitation->gallery_cover;
                $path = "invitations/{$invitation->public_id}/cover/cover.webp";

                $this->uploadImageAsWebP($file, $path, 1600);

                if ($oldPath && $oldPath !== $path) {
                    $this->imageDisk()->delete($oldPath);
                }

                $invitation->update(['gallery_cover' => $path]);

                @unlink($tempPath);

                return response()->json([
                    'success' => true,
                    'url' => storage_url($path, $invitation->updated_at->timestamp),
                    'path' => $path,
                ]);
            }

            if ($type === 'groom') {
                $oldPath = $invitation->foto_pria;
                $path = "invitations/{$invitation->public_id}/pria/pria.webp";

                $this->uploadImageAsWebP($file, $path, 1200);

                if ($oldPath && $oldPath !== $path) {
                    $this->imageDisk()->delete($oldPath);
                }

                $invitation->update(['foto_pria' => $path]);

                @unlink($tempPath);

                return response()->json([
                    'success' => true,
                    'url' => storage_url($path, $invitation->updated_at->timestamp),
                    'path' => $path,
                ]);
            }

            if ($type === 'bride') {
                $oldPath = $invitation->foto_wanita;
                $path = "invitations/{$invitation->public_id}/wanita/wanita.webp";

                $this->uploadImageAsWebP($file, $path, 1200);

                if ($oldPath && $oldPath !== $path) {
                    $this->imageDisk()->delete($oldPath);
                }

                $invitation->update(['foto_wanita' => $path]);

                @unlink($tempPath);

                return response()->json([
                    'success' => true,
                    'url' => storage_url($path, $invitation->updated_at->timestamp),
                    'path' => $path,
                ]);
            }

            @unlink($tempPath);
            return response()->json(['success' => false, 'message' => 'Tipe tidak valid.'], 400);

        } catch (\Throwable $e) {
            if (isset($tempPath) && file_exists($tempPath)) {
                @unlink($tempPath);
            }
            \Log::error('Pixabay import failed: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengimpor gambar: '.$e->getMessage(),
            ], 500);
        }
    }
}
