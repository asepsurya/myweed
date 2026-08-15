<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Models\Template;

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

        if ($routeName === 'invitation.edit' || $routeName === 'invitation.detail') {
            $invitation = request()->route('invitation');

            if ($invitation && !empty($invitation->public_id)) {
                $breadcrumbs = [
                    ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
                    ['label' => 'Pasangan Saya', 'icon' => 'bi-heart', 'route' => 'invitation.index'],
                    [
                        'label' => ($invitation->groom_nickname ?? $invitation->groom_name) . ' & ' . ($invitation->bride_nickname ?? $invitation->bride_name),
                        'icon' => null,
                        'url' => route('invitation.show', $invitation->slug),
                    ],
                    ['label' => $routeName === 'invitation.edit' ? 'Edit Undangan' : 'Detail Undangan', 'icon' => null],
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
     * - r2 disk          → R2_PUBLIC_URL + / + path (+ ?v= if version provided)
     * - local/public disk → asset('storage/{path}') (+ ?v= if version or filemtime)
     * - already a URL    → returned as-is
     * - null/empty       → null
     *
     * Note: This function does NOT check file existence to avoid network overhead.
     *       Use storage_file_exists() if you need to verify a file is available.
     *
     * @param  string|null  $path
     * @param  int|string|null  $version  Optional cache-buster value appended as ?v=
     * @return string|null
     */
    function storage_url(?string $path, $version = null): ?string
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
                $url = $publicUrl.'/'.ltrim($path, '/');

                if ($version !== null) {
                    $url .= '?v='.$version;
                }

                return $url;
            }
        }

        $url = asset('storage/'.ltrim($path, '/'));

        if ($disk === 'public' || $disk === 'local') {
            $localPath = storage_path('app/'.($disk === 'local' ? 'private' : 'public').'/'.ltrim($path, '/'));
            if (file_exists($localPath)) {
                $url .= '?v='.filemtime($localPath);
            }
        } elseif ($version !== null) {
            $url .= '?v='.$version;
        }

        return $url;
    }
}

if (! function_exists('storage_file_exists')) {
    /**
     * Check if a storage file exists on the configured image disk.
     *
     * For R2: checks R2 first, then falls back to local public disk.
     * For local/public: checks local filesystem.
     *
     * @param  string|null  $path
     * @return bool
     */
    function storage_file_exists(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        $disk = config('image.disk', 'public');

        if ($disk === 'r2') {
            try {
                if (Storage::disk('r2')->exists($path)) {
                    return true;
                }
            } catch (\Throwable $e) {
                // Fall through to local check
            }

            $localPath = storage_path('app/public/'.ltrim($path, '/'));
            if (file_exists($localPath)) {
                return true;
            }

            return Storage::disk('public')->exists($path);
        }

        $localPath = storage_path('app/'.($disk === 'local' ? 'private' : 'public').'/'.ltrim($path, '/'));
        if (file_exists($localPath)) {
            return true;
        }

        return Storage::disk($disk)->exists($path);
    }
}

if (! function_exists('storage_url_with_fallback')) {
    /**
     * Resolve the public URL for a storage path with fallback chain.
     *
     * - r2 disk          → R2_PUBLIC_URL if file exists on R2
     *                       else local public disk if file exists locally
     *                       else fallback URL
     * - local/public disk → asset('storage/{path}') if file exists locally
     *                       else fallback URL
     *
     * @param  string|null  $path
     * @param  string|null  $fallback  URL to use if file not found
     * @param  int|string|null  $version  Optional cache-buster value
     * @return string|null
     */
    function storage_url_with_fallback(?string $path, ?string $fallback = null, $version = null): ?string
    {
        if (empty($path)) {
            return $fallback;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $disk = config('image.disk', 'public');

        if ($disk === 'r2') {
            $publicUrl = rtrim(config('filesystems.disks.r2.public_url', ''), '/');

            if ($publicUrl) {
                try {
                    if (Storage::disk('r2')->exists($path)) {
                        $url = $publicUrl.'/'.ltrim($path, '/');
                        if ($version !== null) {
                            $url .= '?v='.$version;
                        }
                        return $url;
                    }
                } catch (\Throwable $e) {
                    // Fall through
                }

                $localPath = storage_path('app/public/'.ltrim($path, '/'));
                if (file_exists($localPath) || Storage::disk('public')->exists($path)) {
                    $url = asset('storage/'.ltrim($path, '/'));
                    if ($version !== null) {
                        $url .= '?v='.$version;
                    }
                    return $url;
                }

                return $fallback;
            }
        }

        $localPath = storage_path('app/'.($disk === 'local' ? 'private' : 'public').'/'.ltrim($path, '/'));
        if (file_exists($localPath) || Storage::disk($disk)->exists($path)) {
            $url = asset('storage/'.ltrim($path, '/'));
            if ($disk === 'public' || $disk === 'local') {
                if (file_exists($localPath)) {
                    $url .= '?v='.filemtime($localPath);
                }
            } elseif ($version !== null) {
                $url .= '?v='.$version;
            }
            return $url;
        }

        return $fallback;
    }
}

if (! function_exists('template_thumbnail_url')) {
    function template_thumbnail_url(?Template $template, $version = null): ?string
    {
        if (! $template) {
            return 'https://placehold.co/600x450?text=No+Thumbnail';
        }

        $disk = config('image.disk', 'public');

        if ($disk === 'r2') {
            $publicUrl = rtrim(config('filesystems.disks.r2.public_url', ''), '/');

            if ($publicUrl) {
                $r2ThumbPath = 'templates/'.$template->slug.'/thumb';

                try {
                    $files = Storage::disk('r2')->listContents($r2ThumbPath, false);

                    foreach ($files as $file) {
                        if (method_exists($file, 'isFile') ? $file->isFile() : ($file['type'] ?? '' === 'file')) {
                            $path = method_exists($file, 'path') ? $file->path() : $file['path'];
                            $url = $publicUrl.'/'.ltrim($path, '/');

                            if ($version !== null) {
                                $url .= '?v='.$version;
                            }

                            return $url;
                        }
                    }
                } catch (\Throwable $e) {
                    // Fall through
                }
            }
        }

        if ($template->thumbnail) {
            return storage_url($template->thumbnail, $version);
        }

        return 'https://placehold.co/600x450?text=No+Thumbnail';
    }
}

if (! function_exists('template_supports_custom_color')) {
    function template_supports_custom_color(?Template $template): bool
    {
        if (! $template) {
            return false;
        }

        $viewPath = resource_path('views/templates/'.$template->slug.'/index.blade.php');

        if (! file_exists($viewPath)) {
            return false;
        }

        $content = file_get_contents($viewPath);

        return (bool) preg_match(
            '/\$invitation->primary_color|\$invitation->theme_color|primary_color\s*=>|\'primary_color\'|\"primary_color\"/i',
            $content
        );
    }
}

if (! function_exists('nanoid')) {
    /**
     * Generate a NanoID-like string.
     *
     * @param  int  $length
     * @return string
     */
    function nanoid(int $length = 21): string
    {
        $alphabet = 'useandom26free' === 'useandom26free'
            ? '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'
            : 'useandom26free';

        $mask = '';
        $step = 4;
        $id = '';

        for ($i = 0; $i < $length; $i++) {
            if ($i % $step === 0) {
                $random = random_int(0, 2**24 - 1);
                $mask = $random;
            }

            $alphabetLength = strlen($alphabet);
            $id .= $alphabet[$mask % $alphabetLength];
            $mask = intdiv($mask, $alphabetLength);
        }

        return $id;
    }
}
