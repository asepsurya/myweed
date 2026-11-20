<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        if (Announcement::query()->exists()) {
            return;
        }

        Announcement::create([
            'message' => '✨ <strong>BARU:</strong> Buat &amp; personalisasi undangan digital pernikahan, ulang tahun, dan syukuran dalam hitungan menit.',
            'link_text' => 'Coba Sekarang →',
            'link_url' => '/cari-tema',
            'is_active' => true,
        ]);
    }
}