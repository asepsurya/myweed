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
        $freeFeatures = [
            'all_themes' => false,
            'edit_guest_name' => true,
            'rsvp_messages' => true,
            'maps_location' => true,
            'unlimited_recipients' => true,
            'countdown_calendar' => false,
            'gallery' => false,
            'gallery_limit' => 0,
            'virtual_gift' => false,
            'shareable' => false,
            'background_music' => false,
            'gift_accounts' => false,
            'streaming_video' => false,
            'auto_scroll' => false,
            'custom_music' => false,
            'love_story' => false,
            'custom_theme_color' => false,
            'admin_setup' => false,
            'website_builder' => false,
            'budget_management' => false,
            'budget_expenses' => false,
            'vendor_payments' => false,
            'vendor_payment_limit' => 0,
            'savings_goals' => 0,
            'savings_multi_user' => false,
            'auto_savings_rules' => false,
            'savings_projection' => false,
            'financial_export' => false,
        ];

        $basicFeatures = [
            'all_themes' => true,
            'edit_guest_name' => true,
            'rsvp_messages' => true,
            'maps_location' => true,
            'unlimited_recipients' => true,
            'countdown_calendar' => true,
            'gallery' => true,
            'gallery_limit' => 10,
            'virtual_gift' => true,
            'shareable' => true,
            'background_music' => true,
            'gift_accounts' => true,
            'streaming_video' => true,
            'auto_scroll' => true,
            'custom_music' => true,
            'love_story' => true,
            'custom_theme_color' => true,
            'admin_setup' => false,
            'website_builder' => false,
            'budget_management' => true,
            'budget_expenses' => true,
            'vendor_payments' => true,
            'vendor_payment_limit' => 3,
            'savings_goals' => 5,
            'savings_multi_user' => true,
            'auto_savings_rules' => true,
            'savings_projection' => false,
            'financial_export' => false,
        ];

        $proFeatures = [
            'all_themes' => true,
            'edit_guest_name' => true,
            'rsvp_messages' => true,
            'maps_location' => true,
            'unlimited_recipients' => true,
            'countdown_calendar' => true,
            'gallery' => true,
            'gallery_limit' => null,
            'virtual_gift' => true,
            'shareable' => true,
            'background_music' => true,
            'gift_accounts' => true,
            'streaming_video' => true,
            'auto_scroll' => true,
            'custom_music' => true,
            'love_story' => true,
            'custom_theme_color' => true,
            'admin_setup' => true,
            'website_builder' => true,
            'budget_management' => true,
            'budget_expenses' => true,
            'vendor_payments' => true,
            'vendor_payment_limit' => null,
            'savings_goals' => null,
            'savings_multi_user' => true,
            'auto_savings_rules' => true,
            'savings_projection' => true,
            'financial_export' => true,
        ];

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
                'features' => $freeFeatures,
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
                    'Rencana Pernikahan: Yes',
                    'Anggaran: Yes',
                    'Tabungan Multi-User: Yes',
                    'Aturan Tabungan Otomatis: Yes',
                    'Pengeluaran Anggaran: Yes',
                ]),
                'is_free' => false,
                'features' => $basicFeatures,
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
                    'Rencana Pernikahan: Yes',
                    'Anggaran: Yes',
                    'Tabungan Multi-User: Yes',
                    'Aturan Tabungan Otomatis: Yes',
                    'Pengeluaran Anggaran: Yes',
                    'Proyeksi Tabungan: Yes',
                    'Ekspor Keuangan: Yes',
                    'Dibuatin Admin Terima Beres: Yes',
                    'Website Builder: Yes',
                ]),
                'is_free' => false,
                'features' => $proFeatures,
            ]
        );
    }
}
