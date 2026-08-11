<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MusicUploadService
{
    protected string $disk;

    protected array $musicFolders = ['', ''];

    public function __construct(?string $disk = null)
    {
        $this->disk = $disk ?? config('music.disk', config('filesystems.default', 'public'));
    }

    public function uploadMusic(UploadedFile $file, ?string $existingPath = null): string
    {
        if ($existingPath && Storage::disk($this->disk)->exists($existingPath)) {
            Storage::disk($this->disk)->delete($existingPath);
        }

        $filename = time().'_'.Str::random(8).'.'.$file->getClientOriginalExtension();

        return Storage::disk($this->disk)->putFileAs('', $file, $filename, 'public');
    }

    public function uploadCover(UploadedFile $file, ?string $existingPath = null): string
    {
        if ($existingPath && Storage::disk($this->disk)->exists($existingPath)) {
            Storage::disk($this->disk)->delete($existingPath);
        }

        $filename = time().'_'.Str::random(8).'.'.$file->getClientOriginalExtension();

        return Storage::disk($this->disk)->putFileAs('', $file, $filename, 'public');
    }

    public function delete(?string $path): bool
    {
        if (! $path) {
            return false;
        }

        return Storage::disk($this->disk)->delete($path);
    }

    public function getUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return Storage::disk($this->disk)->url($path);
    }

    public static function formatFileSize(?int $bytes): string
    {
        if (! $bytes) {
            return '0 MB';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2).' '.$units[$i];
    }
}
