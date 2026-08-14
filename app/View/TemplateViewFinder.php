<?php

namespace App\View;

use Illuminate\View\FileViewFinder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TemplateViewFinder extends FileViewFinder
{
    public function find($name)
    {
        if (isset($this->views[$name])) {
            return $this->views[$name];
        }

        if (!Str::startsWith($name, 'templates.')) {
            return $this->views[$name] = parent::find($name);
        }

        try {
            return $this->views[$name] = parent::find($name);
        } catch (\InvalidArgumentException $e) {
            // Fall through to R2 lookup
        }

        $relativePath = $this->getRelativePath($name);
        if ($relativePath) {
            $cacheFile = $this->getCachePath($relativePath);

            if (!is_dir(dirname($cacheFile))) {
                mkdir(dirname($cacheFile), 0755, true);
            }

            if (!file_exists($cacheFile)) {
                $r2Paths = [
                    $relativePath,
                    ltrim($relativePath, 'templates/'),
                ];

                foreach ($r2Paths as $r2Path) {
                    try {
                        if (Storage::disk('r2')->exists($r2Path)) {
                            $content = Storage::disk('r2')->get($r2Path);
                            file_put_contents($cacheFile, $content);
                            break;
                        }
                    } catch (\Throwable $e) {
                        // Try next path
                    }
                }
            }

            if (file_exists($cacheFile)) {
                return $this->views[$name] = $cacheFile;
            }
        }

        throw new \InvalidArgumentException("View [{$name}] not found.");
    }

    protected function getRelativePath(string $name): ?string
    {
        $parts = explode('.', $name);
        if (count($parts) < 3) {
            return null;
        }

        $path = implode('/', $parts) . '.blade.php';

        return $path;
    }

    protected function getCachePath(string $relativePath): string
    {
        return storage_path('app/r2-templates/' . $relativePath);
    }

    public function clearCache(string $slug): void
    {
        $cacheDir = storage_path('app/r2-templates/templates/' . $slug);
        if (is_dir($cacheDir)) {
            $this->files->deleteDirectory($cacheDir);
        }

        foreach ($this->views as $name => $path) {
            if (str_starts_with($name, 'templates.'.$slug)) {
                unset($this->views[$name]);
            }
        }
    }
}
