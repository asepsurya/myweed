<?php

namespace App\Http\Controllers;

use App\Http\Requests\YoutubeMusic\StoreYoutubeMusicRequest;
use App\Http\Requests\YoutubeMusic\UpdateYoutubeMusicRequest;
use App\Models\YoutubeMusic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class YoutubeMusicController extends Controller
{
    public function index(Request $request)
    {
        $query = YoutubeMusic::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%')
                ->orWhere('artist', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $youtubeMusics = $query->latest()->paginate(20);

        $stats = [
            'total' => YoutubeMusic::count(),
            'active' => YoutubeMusic::where('is_active', true)->count(),
            'inactive' => YoutubeMusic::where('is_active', false)->count(),
        ];

        return view('dashboard.youtube-music.index', compact('youtubeMusics', 'stats'));
    }

    public function create()
    {
        return view('dashboard.youtube-music.create');
    }

    public function store(StoreYoutubeMusicRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['is_active'] = $request->boolean('is_active', true);

            if (!empty($data['youtube_url']) && empty($data['youtube_id'])) {
                $data['youtube_id'] = $this->extractYoutubeId($data['youtube_url']);
            }

            if (empty($data['cover_url'])) {
                $data['cover_url'] = $data['youtube_id'] ? 'https://img.youtube.com/vi/'.$data['youtube_id'].'/mqdefault.jpg' : null;
            }

            if (empty($data['title']) || empty($data['artist'])) {
                $info = $this->fetchYoutubeInfo($data['youtube_url']);
                if ($info) {
                    if (empty($data['title'])) {
                        $data['title'] = $info['title'] ?? $data['title'];
                    }
                    if (empty($data['artist'])) {
                        $data['artist'] = $info['artist'] ?? $data['artist'];
                    }
                    if (empty($data['cover_url']) && !empty($info['cover'])) {
                        $data['cover_url'] = $info['cover'];
                    }
                }
            }

            YoutubeMusic::create($data);
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'YouTube music berhasil ditambahkan.']);
        }

        return redirect()->route('youtube-music.index')->with('success', 'YouTube music berhasil ditambahkan.');
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'bulk_youtube' => ['required', 'string'],
            'is_active' => ['boolean'],
        ]);

        $lines = preg_split('/\r\n|\r|\n/', $request->input('bulk_youtube', ''));
        $lines = array_filter(array_map('trim', $lines));

        if (empty($lines)) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Mohon masukkan minimal satu link YouTube.'], 422);
            }

            return back()->with('error', 'Mohon masukkan minimal satu link YouTube.')->withInput();
        }

        $isActive = $request->boolean('is_active', true);
        $created = 0;
        $skipped = 0;
        $errors = [];

        DB::transaction(function () use ($lines, $isActive, &$created, &$skipped, &$errors) {
            foreach ($lines as $index => $line) {
                $title = 'YouTube Music '.($created + $skipped + 1);
                $artist = 'Unknown Artist';
                $url = $line;

                if (strpos($line, '|') !== false) {
                    $parts = array_map('trim', explode('|', $line));
                    if (count($parts) >= 2 && filter_var(end($parts), FILTER_VALIDATE_URL)) {
                        $url = array_pop($parts);
                        if (count($parts) >= 2) {
                            $title = array_shift($parts);
                            $artist = array_shift($parts);
                        } elseif (count($parts) === 1) {
                            $title = array_shift($parts);
                        }
                    }
                }

                if (!filter_var($url, FILTER_VALIDATE_URL)) {
                    $errors[] = 'Baris '.($index + 1).': URL tidak valid';
                    $skipped++;

                    continue;
                }

                $youtubeId = $this->extractYoutubeId($url);

                if (!$youtubeId) {
                    $errors[] = 'Baris '.($index + 1).': Gagal mengekstrak YouTube ID';
                    $skipped++;

                    continue;
                }

                $exists = YoutubeMusic::where('youtube_url', $url)->orWhere('youtube_id', $youtubeId)->first();

                if ($exists) {
                    $skipped++;

                    continue;
                }

                $coverUrl = 'https://img.youtube.com/vi/'.$youtubeId.'/mqdefault.jpg';

                if ($title === 'YouTube Music '.($created + $skipped + 1) || $artist === 'Unknown Artist') {
                    $info = $this->fetchYoutubeInfo($url);
                    if ($info) {
                        if ($title === 'YouTube Music '.($created + $skipped + 1)) {
                            $title = $info['title'] ?? $title;
                        }
                        if ($artist === 'Unknown Artist') {
                            $artist = $info['artist'] ?? $artist;
                        }
                        if (!empty($info['cover'])) {
                            $coverUrl = $info['cover'];
                        }
                    }
                }

                YoutubeMusic::create([
                    'title' => $title,
                    'artist' => $artist,
                    'youtube_url' => $url,
                    'youtube_id' => $youtubeId,
                    'cover_url' => $coverUrl,
                    'is_active' => $isActive,
                ]);

                $created++;
            }
        });

        $message = "Import selesai. {$created} lagu baru, {$skipped} dilewati.";
        if (!empty($errors)) {
            $message .= "\nDetail:\n- ".implode('\n- ', $errors);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'created' => $created,
                'skipped' => $skipped,
                'errors' => $errors,
            ]);
        }

        $flash = $created.' lagu berhasil diimport.';
        if ($skipped > 0) {
            $flash .= ' '.$skipped.' dilewati.';
        }

        return redirect()->route('youtube-music.index')->with('success', $flash);
    }

    public function edit(YoutubeMusic $youtubeMusic)
    {
        return view('dashboard.youtube-music.edit', compact('youtubeMusic'));
    }

    public function update(UpdateYoutubeMusicRequest $request, YoutubeMusic $youtubeMusic)
    {
        DB::transaction(function () use ($request, $youtubeMusic) {
            $data = $request->validated();
            $data['is_active'] = $request->boolean('is_active', true);

            if (!empty($data['youtube_url']) && empty($data['youtube_id'])) {
                $data['youtube_id'] = $this->extractYoutubeId($data['youtube_url']);
            }

            if (empty($data['cover_url'])) {
                $data['cover_url'] = $data['youtube_id'] ? 'https://img.youtube.com/vi/'.$data['youtube_id'].'/mqdefault.jpg' : null;
            }

            if (empty($data['title']) || empty($data['artist'])) {
                $info = $this->fetchYoutubeInfo($data['youtube_url']);
                if ($info) {
                    if (empty($data['title'])) {
                        $data['title'] = $info['title'] ?? $data['title'];
                    }
                    if (empty($data['artist'])) {
                        $data['artist'] = $info['artist'] ?? $data['artist'];
                    }
                    if (empty($data['cover_url']) && !empty($info['cover'])) {
                        $data['cover_url'] = $info['cover'];
                    }
                }
            }

            $youtubeMusic->update($data);
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'YouTube music berhasil diperbarui.']);
        }

        return redirect()->route('youtube-music.index')->with('success', 'YouTube music berhasil diperbarui.');
    }

    public function destroy(YoutubeMusic $youtubeMusic)
    {
        try {
            $youtubeMusic->delete();

            if (request()->wantsJson() || request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'YouTube music berhasil dihapus.']);
            }

            return back()->with('success', 'YouTube music berhasil dihapus.');
        } catch (\Throwable $e) {
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus: '.$e->getMessage()], 500);
            }

            return back()->with('error', 'Gagal menghapus: '.$e->getMessage());
        }
    }

    public function apiIndex(Request $request)
    {
        $youtubeMusics = YoutubeMusic::where('is_active', true)
            ->select('id', 'title', 'artist', 'youtube_url', 'youtube_id', 'cover_url', 'is_active')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'title' => $m->title,
                    'artist' => $m->artist,
                    'youtube_url' => $m->youtube_url,
                    'youtube_id' => $m->youtube_id,
                    'cover' => $m->cover_url,
                ];
            });

        return response()->json($youtubeMusics);
    }

    private function extractYoutubeId(string $url): ?string
    {
        preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|u\/\w\/|shorts\/)(?<id>[A-Za-z0-9_-]{11}))/i', $url, $matches);

        return $matches['id'] ?? null;
    }

    private function fetchYoutubeInfo(string $url): ?array
    {
        try {
            $oembedUrl = 'https://www.youtube.com/oembed?url='.urlencode($url).'&format=json';
            $response = \Illuminate\Support\Facades\Http::timeout(10)->get($oembedUrl);

            if ($response->successful()) {
                $data = $response->json();
                $youtubeId = $this->extractYoutubeId($url);

                return [
                    'title' => $data['title'] ?? null,
                    'artist' => $data['author_name'] ?? null,
                    'cover' => $youtubeId ? 'https://img.youtube.com/vi/'.$youtubeId.'/mqdefault.jpg' : null,
                ];
            }
        } catch (\Throwable $e) {
            \Log::warning('Failed to fetch YouTube oEmbed: '.$e->getMessage());
        }

        return null;
    }
}
