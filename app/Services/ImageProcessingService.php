<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;
use Intervention\Image\Exception\NotReadableException;

class ImageProcessingService
{
    protected string $disk;

    protected array $allowedMimes;

    protected int $maxUploadKb;

    protected int $webpQuality;

    protected ?int $defaultMaxWidth;

    public function __construct(?string $disk = null)
    {
        $disk = $disk ?? config('image.disk', 'public');

        // The app historically stores uploaded images on the "public" disk
        // (storage/app/public). Map the admin-facing "local" choice to that
        // disk so uploads continue to land in the same place.
        if ($disk === 'local') {
            $disk = 'public';
        }

        $this->disk = $disk;
        $this->allowedMimes = config('image.allowed_mimes', ['image/jpeg', 'image/png', 'image/webp']);
        $this->maxUploadKb = config('image.max_upload_kb', 10240);
        $this->webpQuality = config('image.webp_quality', 75);
        $this->defaultMaxWidth = config('image.default_max_width', 1920);
    }

    /**
     * Process an uploaded image: validate, resize, convert to WebP, save, delete original.
     *
     * @param  UploadedFile  $file
     * @param  string  $folder  Storage folder (e.g. 'invitations/1/pria')
     * @param  string|null  $filename  Optional filename without extension
     * @param  int|null  $maxWidth  Override max width for this image
     * @return array{path: string, url: string, size: int}
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function process(
        UploadedFile $file,
        string $folder = '',
        ?string $filename = null,
        ?int $maxWidth = null
    ): array {
        $this->validate($file);

        $filename = $filename ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = Str::slug($filename) ?: 'image';
        $targetPath = ltrim($folder, '/').'/'.$safeFilename.'.webp';
        $maxWidth = $maxWidth ?? $this->defaultMaxWidth;

        $sourcePath = $file->getRealPath();

        try {
            $driver = new GdDriver;
            $manager = new ImageManager($driver);
            $image = $manager->read($sourcePath);

            if ($maxWidth && $image->width() > $maxWidth) {
                $image->scale(width: $maxWidth);
            }

            $encoded = $image->toWebp($this->webpQuality);
            $content = (string) $encoded;
        } catch (NotReadableException $e) {
            throw new \RuntimeException('Gagal membaca file gambar: '.$e->getMessage(), 0, $e);
        } catch (\Throwable $e) {
            // Fallback: if GD fails, try to save original as WebP without resize
            try {
                $driver = new GdDriver;
                $manager = new ImageManager($driver);
                $image = $manager->read($sourcePath);
                $encoded = $image->toWebp($this->webpQuality);
                $content = (string) $encoded;
            } catch (\Throwable $e2) {
                throw new \RuntimeException('Gagal memproses gambar: '.$e2->getMessage(), 0, $e2);
            }
        }

        if (strlen($content) === 0) {
            throw new \RuntimeException('Hasil encoding gambar kosong.');
        }

        $disk = Storage::disk($this->disk);

        // Ensure folder exists
        $directory = pathinfo($targetPath, PATHINFO_DIRNAME);
        if ($directory) {
            try {
                if (! $disk->exists($directory)) {
                    $disk->makeDirectory($directory, 0755, true);
                }
            } catch (\Throwable $e) {
                // S3/R2 and other object-storage adapters may fail on directory existence checks
                // because they do not have real directories. makeDirectory is idempotent,
                // and put() will create the necessary prefixes automatically.
                try {
                    $disk->makeDirectory($directory, 0755, true);
                } catch (\Throwable $e2) {
                    // Ignore - the upcoming put() call will handle prefix creation.
                }
            }
        }

        $saved = $disk->put($targetPath, $content);

        if (! $saved || ! $disk->exists($targetPath)) {
            throw new \RuntimeException("Gagal menyimpan file ke storage: {$targetPath}");
        }

        // Delete original uploaded file
        if (is_file($sourcePath) && is_writable($sourcePath)) {
            @unlink($sourcePath);
        }

        $size = strlen($content);

        return [
            'path' => $targetPath,
            'url' => $this->resolveUrl($targetPath),
            'size' => $size,
        ];
    }

    /**
     * Validate uploaded file before processing.
     *
     * @throws \InvalidArgumentException
     */
    protected function validate(UploadedFile $file): void
    {
        if (! $file->isValid()) {
            throw new \InvalidArgumentException('File upload tidak valid.');
        }

        $mime = $file->getMimeType();
        if (! in_array($mime, $this->allowedMimes, true)) {
            throw new \InvalidArgumentException(
                'Format file tidak didukung. Gunakan JPG, PNG, atau WebP. (MIME: '.$mime.')'
            );
        }

        $sizeKb = (int) ceil($file->getSize() / 1024);
        if ($sizeKb > $this->maxUploadKb) {
            throw new \InvalidArgumentException(
                "Ukuran file terlalu besar. Maksimal {$this->maxUploadKb} KB. (File: {$sizeKb} KB)"
            );
        }
    }

    /**
     * Resolve public URL for a stored path.
     */
    protected function resolveUrl(string $path): string
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        if ($this->disk === 'r2') {
            $publicUrl = rtrim(config('filesystems.disks.r2.public_url', ''), '/');

            if ($publicUrl) {
                return $publicUrl.'/'.ltrim($path, '/');
            }
        }

        return Storage::disk($this->disk)->url($path);
    }

    /**
     * Get the current storage disk name.
     */
    public function getDisk(): string
    {
        return $this->disk;
    }

    /**
     * Ensure a directory exists on the configured disk.
     */
    public function ensureDirectory(string $path): void
    {
        $directory = pathinfo($path, PATHINFO_DIRNAME);
        if (! $directory) {
            return;
        }

        try {
            if (! Storage::disk($this->disk)->exists($directory)) {
                Storage::disk($this->disk)->makeDirectory($directory, 0755, true);
            }
        } catch (\Throwable $e) {
            // S3/R2 may fail on directory existence checks.
            try {
                Storage::disk($this->disk)->makeDirectory($directory, 0755, true);
            } catch (\Throwable $e2) {
                // Ignore - put() handles prefix creation automatically on object storage.
            }
        }
    }

    /**
     * Check if a file exists on the configured disk.
     */
    public function exists(?string $path): bool
    {
        if (! $path) {
            return false;
        }

        return Storage::disk($this->disk)->exists($path);
    }

    /**
     * Delete a previously processed image.
     */
    public function delete(?string $path): bool
    {
        if (! $path) {
            return false;
        }

        return Storage::disk($this->disk)->delete($path);
    }
}
