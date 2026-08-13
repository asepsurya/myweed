<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Storage Disk
    |--------------------------------------------------------------------------
    |
    | Disk yang digunakan untuk menyimpan gambar yang telah diproses.
    | Nilai yang dapat diatur melalui pengaturan admin:
    | - 'public'  → storage/app/public (default, cocok untuk development/local)
    | - 'r2'      → Cloudflare R2 bucket
    |
    | Catatan: Jika menggunakan pengaturan admin, pilih 'public' untuk
    | mempertahankan kompatibilitas dengan file yang sudah ada.
    |
    */

    'disk' => env('STORAGE_DRIVER', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Allowed Image Mime Types
    |--------------------------------------------------------------------------
    */

    'allowed_mimes' => ['image/jpeg', 'image/png', 'image/webp'],

    /*
    |--------------------------------------------------------------------------
    | Maximum Upload Size (KB)
    |--------------------------------------------------------------------------
    */

    'max_upload_kb' => 10240, // 10MB

    /*
    |--------------------------------------------------------------------------
    | WebP Quality
    |--------------------------------------------------------------------------
    | Kualitas kompresi WebP (0-100). 75 adalah keseimbangan bagus antara
    | ukuran file dan kualitas visual.
    */

    'webp_quality' => 75,

    /*
    |--------------------------------------------------------------------------
    | Default Max Width
    |--------------------------------------------------------------------------
    | Lebar maksimal default untuk resize. Lebih dari nilai ini akan di-scale.
    | Null = tidak ada resize otomatis.
    */

    'default_max_width' => 1920,

];
