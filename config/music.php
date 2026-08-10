<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Music Storage Disk
    |--------------------------------------------------------------------------
    |
    | Disk yang digunakan untuk menyimpan file musik dan cover.
    | Default: public
    | Opsi lain: local, public, s3, dll sesuai config/filesystems.php
    |
    */

    'disk' => env('MUSIC_STORAGE_DISK', 'public'),

];
