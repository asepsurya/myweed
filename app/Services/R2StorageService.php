<?php

namespace App\Services;

use App\Models\Invitation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class R2StorageService
{
    protected string $imageDisk;

    protected string $publicDisk;

    public function __construct()
    {
        $this->imageDisk = config('image.disk', 'public');
        $this->publicDisk = config('filesystems.default', 'public');
    }

    public function delete(string $path, ?string $disk = null): bool
    {
        $disk = $disk ?? $this->imageDisk;

        if (! $path) {
            return false;
        }

        try {
            $exists = Storage::disk($disk)->exists($path);

            if ($exists) {
                Storage::disk($disk)->delete($path);
            }

            return true;
        } catch (\Throwable $e) {
            Log::warning('R2 file deletion failed', [
                'path' => $path,
                'disk' => $disk,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function deleteMany(array $paths, ?string $disk = null): array
    {
        $disk = $disk ?? $this->imageDisk;

        $success = [];
        $failed = [];

        foreach ($paths as $path) {
            if ($this->delete($path, $disk)) {
                $success[] = $path;
            } else {
                $failed[] = $path;
            }
        }

        return [
            'success' => $success,
            'failed' => $failed,
        ];
    }

    public function exists(string $path, ?string $disk = null): bool
    {
        $disk = $disk ?? $this->imageDisk;

        if (! $path) {
            return false;
        }

        return Storage::disk($disk)->exists($path);
    }

    public function collectInvitationPaths(Invitation $invitation): array
    {
        $publicId = $invitation->public_id;
        $paths = [];

        if ($invitation->foto_pria) {
            $paths[] = $invitation->foto_pria;
        }

        if ($invitation->foto_wanita) {
            $paths[] = $invitation->foto_wanita;
        }

        if ($invitation->gallery_cover) {
            $paths[] = $invitation->gallery_cover;
        }

        foreach ($invitation->galleries as $gallery) {
            if ($gallery->image) {
                $paths[] = $gallery->image;
            }
        }

        $loveStory = $invitation->love_story ?? [];

        if (is_array($loveStory)) {
            foreach ($loveStory as $story) {
                if (isset($story['photo']) && $story['photo']) {
                    $paths[] = $story['photo'];
                }
            }
        }

        $paths[] = "invitations/{$publicId}/love_story";

        if ($invitation->music && ! is_numeric($invitation->music)) {
            $paths[] = $invitation->music;
        }

        return array_values(array_unique($paths));
    }

    public function deleteInvitationAssets(Invitation $invitation): array
    {
        $paths = $this->collectInvitationPaths($invitation);

        $imageDiskPaths = [];
        $publicDiskPaths = [];

        foreach ($paths as $path) {
            if (str_starts_with($path, 'invitations/') || str_starts_with($path, 'love_story/')) {
                $imageDiskPaths[] = $path;
            } else {
                $publicDiskPaths[] = $path;
            }
        }

        $imageResult = $this->deleteMany($imageDiskPaths, $this->imageDisk);

        $publicSuccess = [];
        $publicFailed = [];

        foreach ($publicDiskPaths as $path) {
            if ($this->delete($path, $this->publicDisk)) {
                $publicSuccess[] = $path;
            } else {
                $publicFailed[] = $path;
            }
        }

        return [
            'success' => array_merge($imageResult['success'], $publicSuccess),
            'failed' => array_merge($imageResult['failed'], $publicFailed),
            'total' => count($paths),
            'deleted_dirs' => $this->deleteInvitationDirectories($invitation->public_id),
        ];
    }

    public function deleteInvitationDirectories(string $publicId): array
    {
        $dirs = [
            "invitations/{$publicId}/love_story",
        ];

        $deleted = [];

        foreach ($dirs as $dir) {
            try {
                if (Storage::disk($this->imageDisk)->exists($dir)) {
                    Storage::disk($this->imageDisk)->deleteDirectory($dir);
                    $deleted[] = $dir;
                }
            } catch (\Throwable $e) {
                Log::warning('R2 directory deletion failed', [
                    'dir' => $dir,
                    'disk' => $this->imageDisk,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $deleted;
    }

    public function getDisk(): string
    {
        return $this->imageDisk;
    }
}
