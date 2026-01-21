<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use App\Models\Music;
use App\Models\Gallery;
use App\Models\Template;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Intervention\Image\ImageManager;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;;

class UserInvitationController extends Controller
{
     public function index()
    {
        $invitations = Invitation::with('user')->get();
        return view('dashboard.invitation.index', compact('invitations'));
    }

    public function create()
    {
        $music = Music::where('is_active', true)->get();
        $templates = Template::where('is_active', true)->get();
        return view('dashboard.invitation.create', compact('templates', 'music'));
    }

    private function uploadCompressedImage($file, $fullPath, $maxWidth = 1600)
    {

        if (!$file->isValid() || !str_starts_with($file->getMimeType(), 'image/')) {
            throw new \Exception("File upload tidak valid atau bukan gambar.");
        }

        $driver = new GdDriver();
        $manager = new ImageManager($driver);

        $image = $manager->read($file->getRealPath());
        $encoded = $image->encodeByExtension('webp', 75);

        $folder = pathinfo($fullPath, PATHINFO_DIRNAME);
        if (!Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->makeDirectory($folder);
        }

        Storage::disk('public')->put($fullPath, (string) $encoded);

        return $fullPath;
    }
    public function store(Request $request)
    {
        $request->validate([
            'bride_name' => 'required|string|max:255',
            'groom_name' => 'required|string|max:255',
            'wedding_date' => 'required|date',
            'template_id' => 'required|exists:templates,id',

            // Gallery → hanya cek file type & size, jangan decode
            'gallery.*' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp|max:10240', // 10MB

            // Cover
            'gallery_cover' => 'nullable|file|mimes:jpeg,jpg,png,webp|max:10240',

            // Audio → cek mime type & size
            'custom_music' => 'nullable|file|mimes:mp3,wav,ogg|max:10240', // 10MB

            // Foto pria/wanita
            'foto_pria' => 'nullable|file|mimes:jpeg,jpg,png,webp|max:10240',
            'foto_wanita' => 'nullable|file|mimes:jpeg,jpg,png,webp|max:10240',

            // Text story → aman
            'love_story.*' => 'nullable|string|max:5000',

            // Story photos → cek file & mime type
            'story_photo.*' => 'nullable|file|mimes:jpeg,jpg,png,webp|max:10240',
        ]);


        DB::transaction(function () use ($request) {

            $stories = [];

            if ($request->has('love_story')) {
                foreach ($request->love_story as $index => $storyText) {

                    $photoPath = null;

                    if ($request->hasFile('story_photo.' . $index)) {
                        $photoPath = $request->file('story_photo.' . $index)
                            ->store('love_story', 'public');
                    }

                    $stories[] = [
                        'title' => $request->story_title[$index] ?? null,
                        'story' => $storyText,
                        'photo' => $photoPath,
                    ];
                }
            }
            $invitation = Invitation::create([
                'user_id' => $request->user()->id,
                'template_id' => $request->template_id,
                'slug' => Str::slug($request->groom_name . '-' . $request->bride_name),

                'groom_name' => $request->groom_name,
                'groom_nickname' => $request->groom_nickname,
                'groom_father_name' => $request->groom_father_name,
                'groom_mother_name' => $request->groom_mother_name,

                'bride_name' => $request->bride_name,
                'bride_nickname' => $request->bride_nickname,
                'bride_father_name' => $request->bride_father_name,
                'bride_mother_name' => $request->bride_mother_name,

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
                'love_story' => $stories,

                'enable_rsvp' => $request->has('enable_rsvp'),
                'enable_gift' => $request->has('enable_gift'),

                'groom_instagram' =>$request->groom_instagram,
                'groom_username_instagram'=>$request->groom_username_instagram,
                'bride_instagram' =>$request->bride_instagram,
                'bride_username_instagram'=>$request->bride_username_instagram,
                'akad_address'=>$request->akad_address,
                'resepsi_address'=>$request->resepsi_address

            ]);
            if ($request->hasFile('foto_pria')) {
                $path = "invitations/{$invitation->id}/pria/pria.webp";

                $this->uploadCompressedImage(
                    $request->file('foto_pria'),
                    $path,
                    1200
                );

                $invitation->update([
                    'foto_pria' => $path
                ]);
            }

            if ($request->hasFile('foto_wanita')) {
                    $path = "invitations/{$invitation->id}/wanita/wanita.webp";

                    $this->uploadCompressedImage(
                        $request->file('foto_wanita'),
                        $path,
                        1200
                    );

                    $invitation->update([
                        'foto_wanita' => $path
                    ]);
                }


           if ($request->hasFile('gallery_cover')) {
                $path = "invitations/{$invitation->id}/cover/cover.webp";

                $this->uploadCompressedImage(
                    $request->file('gallery_cover'),
                    $path,
                    1600
                );

                $invitation->update(['gallery_cover' => $path]);
            }


            if ($request->hasFile('custom_music')) {
                $musicPath = $request->file('custom_music')
                    ->store("invitations/{$invitation->id}/music", 'public');

                $invitation->update(['music' => $musicPath]);
            }else{
                 $invitation->update([
                    'music' => $request->music_id,
                ]);
            }

           if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $index => $imageFile) {
                    // Tentukan path folder
                    $folder = "invitations/{$invitation->id}/gallery";

                    // Pastikan folder ada
                    if (!Storage::disk('public')->exists($folder)) {
                        Storage::disk('public')->makeDirectory($folder);
                    }

                    // Simpan file asli tanpa compress
                    $path = $imageFile->storeAs($folder, $imageFile->getClientOriginalName(), 'public');

                    // Simpan record di database
                    Gallery::create([
                        'invitation_id' => $invitation->id,
                        'image' => $path,
                    ]);
                }
            }
            if ($request->has('enable_gift') && $request->enable_gift) {
                $banks = $request->bank;
                $numbers = $request->number;
                $names = $request->name;
                $qrs = $request->file('qr');

                foreach ($banks as $i => $bank) {
                    $giftData = [
                        'invitation_id' => $request->invitation_id,
                        'bank' => $bank,
                        'number' => $numbers[$i],
                        'name' => $names[$i],
                    ];

                    if (isset($qrs[$i])) {
                        $giftData['qr'] = $qrs[$i]->store('gifts', 'public');
                    }

                    Gift::create($giftData);
                }
            }
        });
        return redirect()
            ->route('invitation.index')
            ->with('success', 'Undangan berhasil dibuat 💖') ;
    }

    public function edit(Invitation $invitation)
    {
         $music = Music::where('is_active', true)->get();
        $templates = Template::where('is_active', true)->get();

        return view('dashboard.invitation.edit', compact('invitation','music','templates'));
    }


    public function update(Request $request, Invitation $invitation)
    {

        $request->validate([
            'bride_name' => 'required|string|max:255',
            'groom_name' => 'required|string|max:255',
            'wedding_date' => 'required|date',
            'template_id' => 'required|exists:templates,id',
            'gallery.*' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp|max:10240',
            'gallery_cover' => 'nullable|file|mimes:jpeg,jpg,png,webp|max:10240',
            'custom_music' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
        ]);

        DB::transaction(function () use ($request, $invitation) {
         $oldStories = is_string($invitation->love_story)
            ? json_decode($invitation->love_story, true)
            : $invitation->love_story;

        $oldStories = $oldStories ?? [];
        $stories = [];

        if ($request->has('love_story')) {
            foreach ($request->love_story as $index => $storyText) {

                // Default pakai foto lama
                $photoPath = $oldStories[$index]['photo'] ?? null;

                // Kalau ada foto baru → ganti
                if ($request->hasFile('story_photo.' . $index)) {

                    if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                        Storage::disk('public')->delete($photoPath);
                    }

                    $photoPath = $request->file('story_photo.' . $index)
                        ->store('love_story', 'public');
                }

                $stories[] = [
                    'title' => $request->story_title[$index] ?? null,
                    'story' => $storyText,
                    'photo' => $photoPath,
                ];
            }
        }

            // Siapkan data untuk diupdate, termasuk slug yang baru
            $updateData = [
                'template_id' => $request->template_id,
                'slug' => Str::slug($request->groom_name . '-' . $request->bride_name),

                'groom_name' => $request->groom_name,
                'groom_nickname' => $request->groom_nickname,
                'groom_father_name' => $request->groom_father_name,
                'groom_mother_name' => $request->groom_mother_name,

                'bride_name' => $request->bride_name,
                'bride_nickname' => $request->bride_nickname,
                'bride_father_name' => $request->bride_father_name,
                'bride_mother_name' => $request->bride_mother_name,

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
                'love_story' => $stories,

                'enable_rsvp' => $request->has('enable_rsvp'),
                'enable_gift' => $request->has('enable_gift'),

                'groom_instagram' =>$request->groom_instagram,
                'groom_username_instagram'=>$request->groom_username_instagram,
                'bride_instagram' =>$request->bride_instagram,
                'bride_username_instagram'=>$request->bride_username_instagram,
                'akad_address'=>$request->akad_address,
                'resepsi_address'=>$request->resepsi_address
            ];

            // Update data utama undangan
            $invitation->update($updateData);

            // --- Proses Update File ---

            if ($request->hasFile('foto_pria')) {
                if ($invitation->foto_pria) {
                    Storage::disk('public')->delete($invitation->foto_pria);
                }

                $pathPria = "invitations/{$invitation->id}/pria/pria.jpg";
                $fotoPria = $this->uploadCompressedImage($request->file('foto_pria'), $pathPria);

                $invitation->update(['foto_pria' => $fotoPria]);
            }

            if ($request->hasFile('foto_wanita')) {
                if ($invitation->foto_wanita) {
                    Storage::disk('public')->delete($invitation->foto_wanita);
                }

                $pathWanita = "invitations/{$invitation->id}/wanita/wanita.jpg";
                $fotoWanita = $this->uploadCompressedImage($request->file('foto_wanita'), $pathWanita);

                $invitation->update(['foto_wanita' => $fotoWanita]);
            }

            // 3. Cover Galeri
            if ($request->hasFile('gallery_cover')) {

                // Hapus cover lama
                if ($invitation->gallery_cover) {
                    Storage::disk('public')->delete($invitation->gallery_cover);
                }

                // Path cover baru (kita tentukan sendiri)
                $path = "invitations/{$invitation->id}/cover/cover.jpg";

                // Upload & compress pakai function
                $this->uploadCompressedImage(
                    $request->file('gallery_cover'),
                    $path,
                    1600
                );

                // Update database
                $invitation->update(['gallery_cover' => $path]);
            }

            // 4. Musik Kustom
            if ($request->hasFile('custom_music')) {
                // Hapus musik lama jika ada
                if ($invitation->music) {
                    Storage::disk('public')->delete($invitation->music);
                }
                // Simpan musik baru
                $musicPath = $request->file('custom_music')->store("invitations/{$invitation->id}/music", 'public');
                $invitation->update(['music' => $musicPath]);
            }else{
                 $invitation->update([
                    'music' => $request->music_id,
                ]);
            }

        if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $index => $imageFile) {
                    // Tentukan path folder
                    $folder = "invitations/{$invitation->id}/gallery";

                    // Pastikan folder ada
                    if (!Storage::disk('public')->exists($folder)) {
                        Storage::disk('public')->makeDirectory($folder);
                    }

                    // Simpan file asli tanpa compress
                    $path = $imageFile->storeAs($folder, $imageFile->getClientOriginalName(), 'public');

                    // Simpan record di database
                    Gallery::create([
                        'invitation_id' => $invitation->id,
                        'image' => $path,
                    ]);
                }
            }

           if ($request->enable_gift == 1) {

                $banks   = $request->bank ?? [];
                $numbers = $request->number ?? [];
                $names   = $request->name ?? [];
                $qrs     = $request->file('qr') ?? [];

                foreach ($banks as $i => $bank) {

                    // Skip jika data wajib kosong
                    if (
                        empty($numbers[$i]) ||
                        empty($names[$i])
                    ) {
                        continue;
                    }

                    $data = [
                        'number' => $numbers[$i],
                        'name'   => $names[$i],
                    ];

                    // Jika upload QR baru
                    if (isset($qrs[$i])) {
                        $data['qr'] = $qrs[$i]->store('gifts', 'public');
                    }

                    Gift::updateOrCreate(
                        [
                            'invitation_id' => $request->invitation_id,
                            'bank' => $bank,
                        ],
                        $data
                    );
                }
            }

        });

        return redirect()
            ->back()
            ->with('success', 'Undangan berhasil diperbarui 💖');
    }

    public function destroyGallery(Invitation $invitation, Request $request,$id)
    {
        $photo = Gallery::findOrFail($id);

        // Hapus file
        Storage::disk('public')->delete($photo->image);

        // Hapus data
        $photo->delete();

        return response()->json(['success' => true]);
    }
    public function detail($slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();
        // abort_if($invitation->user_id !== auth()->id(), 403);
        $galleries = Gallery::where('invitation_id', $invitation->id)->get();
        return view('dashboard.invitation.detail', compact('invitation','galleries'));
    }

}
