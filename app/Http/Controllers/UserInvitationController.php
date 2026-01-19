<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use App\Models\Music;
use App\Models\Gallery;
use App\Models\Template;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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

    public function store(Request $request)
    {
        $request->validate([
                'bride_name' => 'required',
                'groom_name' => 'required',
                'wedding_date' => 'required|date',
                'template_id' => 'required|exists:templates,id',
                'gallery.*' => 'nullable|image|max:51200',
                'gallery_cover' => 'nullable|image',
                'custom_music' => 'nullable|audio/*',
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
                'akad_maps' => $request->akad_maps,

                'resepsi_location' => $request->resepsi_location,
                'resepsi_time' => $request->resepsi_time,
                'resepsi_maps' => $request->resepsi_maps,

                'theme_color' => $request->theme_color,
                'quote_id' => $request->quote_id,
                'wedding_quote' => $request->wedding_quote,
                'video_link' => $request->video_link,
                'love_story' => $stories,

                'enable_rsvp' => $request->has('enable_rsvp'),
                'enable_gift' => $request->has('enable_gift'),

                'groom_instagram' =>$request->groom_instagram,
                'bride_instagram' =>$request->bride_instagram,
            ]);
            if ($request->hasFile('foto_pria')) {
                $fotoPria = $request->file('foto_pria')
                    ->store("invitations/{$invitation->id}/pria", 'public');

                $invitation->update(['foto_pria' => $fotoPria]);
            }

            if ($request->hasFile('foto_wanita')) {
                $fotoWanita = $request->file('foto_wanita')
                    ->store("invitations/{$invitation->id}/wanita", 'public');

                $invitation->update(['foto_wanita' => $fotoWanita]);
            }

            if ($request->hasFile('gallery_cover')) {
                $coverPath = $request->file('gallery_cover')
                    ->store("invitations/{$invitation->id}/cover", 'public');

                $invitation->update(['gallery_cover' => $coverPath]);
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
                foreach ($request->file('gallery') as $image) {
                    $path = $image->store(
                        "invitations/{$invitation->id}/gallery",
                        'public'
                    );
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


    // Validasi data input
        $request->validate([
            'bride_name' => 'required',
            'groom_name' => 'required',
            'wedding_date' => 'required|date',
            'template_id' => 'required|exists:templates,id',
            'gallery.*' => 'nullable|image|max:51200', // 50MB
            'gallery_cover' => 'nullable|image',
            'custom_music' => 'nullable|mimes:audio/mpeg,mp3,ogg,wav', // Validasi lebih spesifik untuk audio
        ]);

        DB::transaction(function () use ($request, $invitation) {
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
                'akad_maps' => $request->akad_maps,

                'resepsi_location' => $request->resepsi_location,
                'resepsi_time' => $request->resepsi_time,
                'resepsi_maps' => $request->resepsi_maps,

                'theme_color' => $request->theme_color,
                'quote_id' => $request->quote_id,
                'wedding_quote' => $request->wedding_quote,
                'video_link' => $request->video_link,
                'love_story' => $stories,

                'enable_rsvp' => $request->has('enable_rsvp'),
                'enable_gift' => $request->has('enable_gift'),

                'groom_instagram' =>$request->groom_instagram,
                'bride_instagram' =>$request->bride_instagram,
            ];

            // Update data utama undangan
            $invitation->update($updateData);

            // --- Proses Update File ---

            // 1. Foto Mempelai Pria
            if ($request->hasFile('foto_pria')) {
                // Hapus foto lama jika ada
                if ($invitation->foto_pria) {
                    Storage::disk('public')->delete($invitation->foto_pria);
                }
                // Simpan foto baru
                $fotoPria = $request->file('foto_pria')->store("invitations/{$invitation->id}/pria", 'public');
                $invitation->update(['foto_pria' => $fotoPria]);
            }

            // 2. Foto Mempelai Wanita
            if ($request->hasFile('foto_wanita')) {
                // Hapus foto lama jika ada
                if ($invitation->foto_wanita) {
                    Storage::disk('public')->delete($invitation->foto_wanita);
                }
                // Simpan foto baru
                $fotoWanita = $request->file('foto_wanita')->store("invitations/{$invitation->id}/wanita", 'public');
                $invitation->update(['foto_wanita' => $fotoWanita]);
            }

            // 3. Cover Galeri
            if ($request->hasFile('gallery_cover')) {
                // Hapus cover lama jika ada
                if ($invitation->gallery_cover) {
                    Storage::disk('public')->delete($invitation->gallery_cover);
                }
                // Simpan cover baru
                $coverPath = $request->file('gallery_cover')->store("invitations/{$invitation->id}/cover", 'public');
                $invitation->update(['gallery_cover' => $coverPath]);
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

            // 5. Galeri Foto (Menambahkan foto baru)
            // Logika ini hanya menambah foto baru, tidak menghapus yang lama.
            // Jika Anda ingin mengganti seluruh galeri, Anda perlu logika tambahan (misalnya, menghapus semua Gallery::where('invitation_id', $invitation->id)->delete() sebelum loop ini).
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $path = $image->store("invitations/{$invitation->id}/gallery", 'public');
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
