<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\Invitation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InvitationSeed extends Seeder
{
    public function run(): void
    {
        $invitation = Invitation::updateOrCreate(
            ['slug' => 'romeo-juliet'],
            [
                'user_id' => 1,
                'template_id' => 2,
                'is_default' => true,
                'status' => 'published',
                'primary_color' => '#0d9488',

                // Groom
                'groom_name' => 'Romeo Kertalaksana S.kom',
                'groom_nickname' => 'Romeo',
                'groom_father_name' => 'Tuan Montague',
                'groom_mother_name' => 'Nyonya Montague',
                'groom_child_order' => 'Anak pertama',

                // Bride
                'bride_name' => 'Juliet Mulya Utami S.E., M.Pd',
                'bride_nickname' => 'Juliet',
                'bride_father_name' => 'Tuan Capulet',
                'bride_mother_name' => 'Nyonya Capulet',
                'bride_child_order' => 'Anak ke-3',

                // Wedding
                'wedding_date' => '2026-01-23',

                // Akad
                'akad_location' => 'Masjid Agung Kota Tasikmalaya',
                'akad_time' => '09:00',
                'akad_time_end' => '11:00',
                'akad_address' => 'Jl. Mesjid Agung No.01, Yudanagara, Kec. Tawang, Kab. Tasikmalaya, Jawa Barat 46121',
                'akad_maps' => 'https://www.google.com/maps/place/Masjid+Agung+Kota+Tasikmalaya/@-7.3261207,108.2154042,17z/data=!4m10!1m2!2m1!1sMesjid+agung!3m6!1s0x2e6f5748b3363aff:0x2f0e4a4f98e527ec!8m2!3d-7.3261207!4d108.2201678!15sCgxNYXNqaWQgYWd1bmdaDiIMbWFzamlkIGFndW5nkgEGbW9zcXVlmgFEQ2k5RFFVbFJRVU52WkVOb2RIbGpSamx2VDJ4R1VsWlVZekJOZWtaNVZFWlJNRkZ0UmtkWlZrNUVWakZzU0dWV1JSQULgAQD6AQQIABBH!16s%2Fg%2F122srx56?entry=ttu&g_ep=EgoyMDI2MDgxMS4wIKXMDSoASAFQAw%3D%3D',

                // Resepsi
                'resepsi_location' => 'Alun-Alun Kota Tasikmalaya',
                'resepsi_time' => '11:00',
                'resepsi_time_end' => 'Selesai',
                'resepsi_address' => 'Jl. Otto Iskandardinata, Empangsari, Kec. Tawang, Kab. Tasikmalaya, Jawa Barat 46113',
                'resepsi_maps' => 'google.com/maps/place/Alun-Alun+Kota+Tasikmalaya/@-7.3266396,108.2258899,15z/data=!4m6!3m5!1s0x2e6f5748c56a47f:0xe58559a0f967bda8!8m2!3d-7.3262114!4d108.2241935!16s%2Fg%2F11f3r0q05n?entry=ttu&g_ep=EgoyMDI2MDgxMS4wIKXMDSoASAFQAw%3D%3D',

                // Content
                'quote_id' => 'rum21',
                'wedding_quote' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan untukmu agar kamu merasa tentram. (QS. Ar-Rum : 21)',
                'video_link' => 'https://www.youtube.com/watch?v=EtxEsfoIycg',
                'love_story' => [
                    [
                        'title' => 'Awal Bertemu',
                        'story' => 'Kami bertemu tanpa sengaja dan menemukan cinta.',
                        'photo' => null,
                    ],
                    [
                        'title' => 'Lamaran',
                        'story' => 'Perjalanan cinta kami berlanjut ke tahap yang lebih serius.',
                        'photo' => null,
                    ],
                ],

                // Feature
                'enable_rsvp' => 1,
                'enable_gift' => 1,
                'enable_gallery' => 1,
                'enable_music' => 1,
                'enable_video' => 1,
                'enable_love_story' => 1,
                'music' => '2',
            ]
        );

        $id = $invitation->id;

        // Folder
        $base = "invitations/$id";
        Storage::disk('r2')->makeDirectory("$base/pria");
        Storage::disk('r2')->makeDirectory("$base/wanita");
        Storage::disk('r2')->makeDirectory("$base/cover");
        Storage::disk('r2')->makeDirectory("$base/gallery");
        Storage::disk('r2')->makeDirectory("$base/love_story");

        // Clean up existing galleries to avoid duplicates on re-run
        Gallery::where('invitation_id', $id)->delete();

        // Copy images
        $this->copy(
            public_path('tempelate/love/assets/images/couple/img-2.jpg'),
            "$base/pria/pria.jpg"
        );

        $this->copy(
            public_path('tempelate/love/assets/images/couple/img-1.jpg'),
            "$base/wanita/wanita.jpg"
        );

        $this->copy(
            public_path('tempelate/love/assets/images/blog/img-16.jpg'),
            "$base/cover/cover.jpg"
        );

        $this->copy(
            public_path('tempelate/love/assets/images/blog/img-1.jpg'),
            "$base/love_story/0.jpg"
        );

        $this->copy(
            public_path('tempelate/love/assets/images/blog/img-2.jpg'),
            "$base/love_story/1.jpg"
        );

        $files = glob(
            public_path('tempelate/love/assets/images/blog/*.{jpg,png,webp}'),
            GLOB_BRACE
        );

        $base = "invitations/{$invitation->id}";

        if (! empty($files)) {
            foreach ($files as $file) {

                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $fileName = Str::uuid().'.'.$extension;

                // simpan file ke storage
                Storage::disk('r2')->put(
                    "$base/gallery/$fileName",
                    file_get_contents($file)
                );

                // simpan ke database
                Gallery::create([
                    'invitation_id' => $invitation->id,
                    'image' => "$base/gallery/$fileName",
                ]);
            }
        }

        // Update path image
        $invitation->update([
            'foto_pria' => "$base/pria/pria.jpg",
            'foto_wanita' => "$base/wanita/wanita.jpg",
            'gallery_cover' => "$base/cover/cover.jpg",
            'love_story' => [
                [
                    'title' => 'Awal Bertemu',
                    'story' => 'Kami bertemu tanpa sengaja dan menemukan cinta.',
                    'photo' => "$base/love_story/0.jpg",
                ],
                [
                    'title' => 'Lamaran',
                    'story' => 'Perjalanan cinta kami berlanjut ke tahap yang lebih serius.',
                    'photo' => "$base/love_story/1.jpg",
                ],
            ],
        ]);
    }

    private function copy($from, $to)
    {
        if (file_exists($from)) {
            Storage::disk('r2')->put($to, file_get_contents($from));
        }
    }
}
