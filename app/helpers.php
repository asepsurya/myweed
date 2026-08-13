<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

if (! function_exists('storage_url')) {
    /**
     * Resolve the public URL for a storage path based on the configured image disk.
     *
     * - local/public disk → asset('storage/{path}')
     * - r2 disk          → R2_PUBLIC_URL + / + path
     * - already a URL    → returned as-is
     * - null/empty       → null
     */
    function storage_url(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $disk = config('image.disk', 'public');

        if ($disk === 'r2') {
            $publicUrl = rtrim(config('filesystems.disks.r2.public_url', ''), '/');

            if ($publicUrl) {
                return $publicUrl.'/'.ltrim($path, '/');
            }
        }

        return asset('storage/'.ltrim($path, '/'));
    }
}
