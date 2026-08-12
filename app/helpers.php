<?php

use Illuminate\Support\Facades\Route;

if (! function_exists('get_breadcrumbs')) {
    function get_breadcrumbs(): array
    {
        $routeName = Route::currentRouteName();
        $breadcrumbs = config("breadcrumbs.$routeName", []);

        if (empty($breadcrumbs)) {
            $segments = request()->segments();
            $breadcrumbs[] = ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'];

            $labels = [
                'invitation' => 'Pasangan Saya',
                'weeding-plan' => 'Rencana Pernikahan',
                'budget' => 'Anggaran',
                'savings' => 'Tabungan',
                'financial-overview' => 'Ikhtisar Keuangan',
                'rsvps' => 'Ucapan & Doa',
                'music' => 'Musik Undangan',
                'subscription-plans' => 'Paket & Harga',
                'coupons' => 'Kupon Promo',
                'promotions' => 'Promosi',
                'users' => 'Daftar Pengguna',
                'settings' => 'Pengaturan',
                'template-creator' => 'Template Creator',
                'tempelate' => 'Tema & Tampilan',
                'categories' => 'Kategori',
                'gifts' => 'Hadiah',
                'payments' => 'Pembayaran',
                'profile' => 'Profil',
            ];

            foreach ($segments as $index => $segment) {
                if ($segment === 'admin') {
                    continue;
                }

                $isLast = ($index === count($segments) - 1);
                $label = $labels[$segment] ?? ucfirst(str_replace('-', ' ', $segment));

                $breadcrumbs[] = [
                    'label' => $label,
                    'icon' => null,
                    'route' => $isLast ? null : null,
                ];
            }
        }

        return $breadcrumbs;
    }
}
