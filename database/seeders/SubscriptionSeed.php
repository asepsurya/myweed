<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubscriptionPlan::updateOrCreate(
            ['slug' => 'free'],
            [
                'name' => 'Free',
                'price' => 0,
                'duration' => 3,
                'description' => json_encode([
                    'Uji Coba Gratis',
                    'Akses Seluruh Tema: No',
                    'Ubah Nama Tamu: Yes',
                    'Masa Aktif 3 Hari',
                    'RSVP & Ucapan: Yes',
                    'Lokasi Maps: Yes',
                    'Unlimited Penerima: Yes',
                    'Countdown & Save to Calendar: No',
                    'Gallery: 0 Images',
                    'Virtual Gift: No',
                    'Bisa Disebar: No',
                    'Background Music: No',
                    'Rekening Titip Hadiah: No',
                    'Link Streaming/Video: No',
                    'Auto Scroll: No',
                    'Custom Music: No',
                    'Love Story: No',
                    'Custom Warna Tema: No',
                ]),
                'is_free' => true,
            ]
        );

        SubscriptionPlan::updateOrCreate(
            ['slug' => 'basic'],
            [
                'name' => 'Basic',
                'price' => 50000,
                'duration' => 30,
                'description' => json_encode([
                    'Akses Seluruh Tema: Yes',
                    'Ubah Nama Tamu: Yes',
                    'Masa Aktif 30 Hari',
                    'RSVP & Ucapan: Yes',
                    'Lokasi Maps: Yes',
                    'Unlimited Penerima: Yes',
                    'Countdown & Save to Calendar: Yes',
                    'Gallery: 10 Images',
                    'Virtual Gift: Yes',
                    'Bisa Disebar: Yes',
                    'Background Music: Yes',
                    'Rekening Titip Hadiah: Yes',
                    'Link Streaming/Video: Yes',
                    'Auto Scroll: Yes',
                    'Custom Music: Yes',
                    'Love Story: Yes',
                    'Custom Warna Tema: Yes',
                ]),
                'is_free' => false,
            ]
        );

        SubscriptionPlan::updateOrCreate(
            ['slug' => 'pro'],
            [
                'name' => 'Pro',
                'price' => 100000,
                'duration' => 30,
                'description' => json_encode([
                    'Akses Seluruh Tema: Yes',
                    'Ubah Nama Tamu: Yes',
                    'Masa Aktif 30 Hari',
                    'RSVP & Ucapan: Yes',
                    'Lokasi Maps: Yes',
                    'Unlimited Penerima: Yes',
                    'Countdown & Save to Calendar: Yes',
                    'Gallery: Unlimited',
                    'Virtual Gift: Yes',
                    'Bisa Disebar: Yes',
                    'Background Music: Yes',
                    'Rekening Titip Hadiah: Yes',
                    'Link Streaming/Video: Yes',
                    'Auto Scroll: Yes',
                    'Custom Music: Yes',
                    'Love Story: Yes',
                    'Custom Warna Tema: Yes',
                    'Dibuatin Admin Terima Beres: Yes',
                    'Website Builder: Yes',
                ]),
                'is_free' => false,
            ]
        );
    }
}
