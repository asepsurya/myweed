<?php

namespace App\Http\Controllers;

use App\Http\Requests\Music\StoreMusicRequest;
use App\Http\Requests\Music\UpdateMusicRequest;
use App\Models\Music;
use App\Services\R2UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MusicController extends Controller
{
    protected R2UploadService $uploader;

    public function __construct()
    {
        $this->uploader = new R2UploadService();
    }

    public function index(Request $request)
    {
        $query = Music::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('artist', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $musics = $query->latest()->paginate(20);

        $stats = [
            'total' => Music::count(),
            'active' => Music::where('is_active', true)->count(),
            'inactive' => Music::where('is_active', false)->count(),
            'storage' => $this->formatTotalStorage(Music::sum('file_size')),
        ];

        return view('dashboard.music.index', compact('musics', 'stats'));
    }

    public function create()
    {
        return view('dashboard.music.create');
    }

    public function store(StoreMusicRequest $request)
    {
        DB::transaction(function () use ($request) {
            $music = new Music();
            $music->title = $request->title;
            $music->artist = $request->artist;
            $music->album = $request->album;
            $music->duration = $request->duration;
            $music->is_active = $request->boolean('is_active', true);

            if ($request->hasFile('music_file')) {
                $file = $request->file('music_file');
                $music->audio_url = $this->uploader->uploadMusic($file);
                $music->music_url = $music->audio_url;
                $music->file_size = $file->getSize();
                $music->mime_type = $file->getMimeType();
            }

            if ($request->hasFile('cover')) {
                $music->cover_url = $this->uploader->uploadCover($request->file('cover'));
            }

            $music->save();
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Lagu berhasil ditambahkan.']);
        }

        return redirect()->route('music.index')->with('success', 'Lagu berhasil ditambahkan.');
    }

    public function edit(Music $music)
    {
        return view('dashboard.music.edit', compact('music'));
    }

    public function update(UpdateMusicRequest $request, Music $music)
    {
        DB::transaction(function () use ($request, $music) {
            $music->title = $request->title;
            $music->artist = $request->artist;
            $music->album = $request->album;
            $music->duration = $request->duration;
            $music->is_active = $request->boolean('is_active', true);

            if ($request->hasFile('music_file')) {
                $this->uploader->delete($music->audio_url);
                $this->uploader->delete($music->music_url);

                $file = $request->file('music_file');
                $music->audio_url = $this->uploader->uploadMusic($file);
                $music->music_url = $music->audio_url;
                $music->file_size = $file->getSize();
                $music->mime_type = $file->getMimeType();
            }

            if ($request->hasFile('cover')) {
                $this->uploader->delete($music->cover_url);
                $music->cover_url = $this->uploader->uploadCover($request->file('cover'));
            }

            $music->save();
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Lagu berhasil diperbarui.']);
        }

        return redirect()->route('music.index')->with('success', 'Lagu berhasil diperbarui.');
    }

    public function destroy(Music $music)
    {
        try {
            if ($music->audio_url) {
                $this->uploader->delete($music->audio_url);
            }
            if ($music->music_url && $music->music_url !== $music->audio_url) {
                $this->uploader->delete($music->music_url);
            }
            if ($music->cover_url) {
                $this->uploader->delete($music->cover_url);
            }

            $music->delete();

            if (request()->wantsJson() || request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Lagu berhasil dihapus.']);
            }

            return back()->with('success', 'Lagu berhasil dihapus.');
        } catch (\Throwable $e) {
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus: ' . $e->getMessage()], 500);
            }

            return back()->with('error', 'Gagal menghapus lagu: ' . $e->getMessage());
        }
    }

    public function apiIndex(Request $request)
    {
        $musics = Music::where('is_active', true)
            ->select('id', 'title', 'artist', 'album', 'cover_url', 'audio_url', 'music_url', 'duration', 'is_active')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'title' => $m->title,
                    'artist' => $m->artist,
                    'album' => $m->album,
                    'cover' => $this->uploader->getUrl($m->cover_url),
                    'audio' => $this->uploader->getUrl($m->music_url ?? $m->audio_url),
                    'duration' => (int) ($m->duration ?? 0),
                ];
            });

        return response()->json($musics);
    }

    public function apiShow(Music $music)
    {
        return response()->json([
            'id' => $music->id,
            'title' => $music->title,
            'artist' => $music->artist,
            'album' => $music->album,
            'cover' => $this->uploader->getUrl($music->cover_url),
            'audio' => $this->uploader->getUrl($music->music_url ?? $music->audio_url),
            'duration' => (int) ($music->duration ?? 0),
        ]);
    }

    public function syncR2(Request $request)
    {
        $disk = config('music.disk', 'r2');
        $onlyMp3 = true;

        try {
            $files = collect(Storage::disk($disk)->files(''))
                ->filter(function ($path) use ($onlyMp3) {
                    return preg_match('/\.(mp3|wav|ogg|m4a)$/i', $path);
                })
                ->values();
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Gagal membaca disk: ' . $e->getMessage()], 500);
        }

        if ($files->isEmpty()) {
            return response()->json(['success' => true, 'message' => 'Tidak ada file musik baru.', 'created' => 0]);
        }

        $created = 0;
        $skipped = 0;

        foreach ($files as $path) {
            $filename = basename($path);
            $existing = Music::where('audio_url', $path)
                ->orWhere('music_url', $path)
                ->first();

            if ($existing) {
                $skipped++;
                continue;
            }

            Music::create([
                'title'     => pathinfo($filename, PATHINFO_FILENAME),
                'artist'    => 'Unknown Artist',
                'audio_url' => $path,
                'music_url' => $path,
                'file_size' => Storage::disk($disk)->size($path) ?? null,
                'mime_type' => Storage::disk($disk)->mimeType($path) ?? null,
                'is_active' => true,
            ]);
            $created++;
        }

        return response()->json([
            'success' => true,
            'message' => "Sinkronisasi selesai. {$created} lagu baru, {$skipped} dilewati.",
            'created' => $created,
            'skipped' => $skipped,
        ]);
    }

    private function formatTotalStorage(?int $bytes): string
    {
        if (!$bytes) return '0 MB';

        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
