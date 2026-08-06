<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InvitationSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run(): void
    {
        $invitation = Invitation::create([
            'user_id'       => 1,
            'template_id'   => 2,
            'slug'          => 'romeo-juliet',
            'is_default'    => true,

            // Groom
            'groom_name'        => 'Romeo',
            'groom_nickname'    => 'Romeo',
            'groom_father_name' => 'Tuan Montague',
            'groom_mother_name' => 'Nyonya Montague',

            // Bride
            'bride_name'        => 'Juliet',
            'bride_nickname'    => 'Juliet',
            'bride_father_name' => 'Tuan Capulet',
            'bride_mother_name' => 'Nyonya Capulet',

            // Wedding
            'wedding_date'      => '2026-01-23',

            // Akad
            'akad_location'     => 'Gedung Harmoni',
            'akad_time'         => '09:00',
            'akad_address'      => 'Jalan Mangkoko No.41',
            'akad_time_end'     => '11:00',
            'akad_maps'         => 'https://maps.google.com',

            // Resepsi
            'resepsi_location'  => 'Ballroom Grand Verona',
            'resepsi_address'  => 'Jalan Mangkoko No.41',
            'resepsi_time'      => '11:00',
            'resepsi_time_end'  => 'Selesai',
            'resepsi_maps'      => 'https://maps.google.com',

            // Theme
            'theme_color'       => '#C9A24D',
            'enable_gift'       => '1',

            // Content
            'wedding_quote'     =>
                'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan untukmu agar kamu merasa tentram. (QS. Ar-Rum : 21)',

            'video_link'        => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',

            'love_story'        => [
                [
                    'title' => 'Awal Bertemu',
                    'story' => 'Kami bertemu tanpa sengaja dan menemukan cinta.',
                    'photo' => null,
                ],
                [
                    'title' => 'Lamaran',
                    'story' => 'Perjalanan cinta kami berlanjut ke tahap yang lebih serius.',
                    'photo' => null,
                ]
            ],

            // Feature
            'enable_rsvp'       => 1,
            'music'             => 2,
        ]);

        $id = $invitation->id;

        // Folder
        $base = "invitations/$id";
        Storage::disk('public')->makeDirectory("$base/pria");
        Storage::disk('public')->makeDirectory("$base/wanita");
        Storage::disk('public')->makeDirectory("$base/cover");
        Storage::disk('public')->makeDirectory("$base/gallery");

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

      $files = glob(
            public_path('tempelate/love/assets/images/blog/*.{jpg,png,webp}'),
            GLOB_BRACE
        );

        $base = "invitations/{$invitation->id}";

        if (!empty($files)) {
            foreach ($files as $file) {

                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $fileName  = Str::uuid() . '.' . $extension;

                // simpan file ke storage
                Storage::disk('public')->put(
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
            'foto_pria'     => "$base/pria/pria.jpg",
            'foto_wanita'   => "$base/wanita/wanita.jpg",
            'gallery_cover' => "$base/cover/cover.jpg",
        ]);
    }

    private function copy($from, $to)
    {
        if (file_exists($from)) {
            Storage::disk('public')->put($to, file_get_contents($from));
        }
    }
}
