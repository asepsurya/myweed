<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'title',
        'image',
        'link_url',
        'video_url',
        'video_file',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Determine the media type of the promotion: video (uploaded), youtube, or image.
     */
    public function getMediaTypeAttribute(): string
    {
        if ($this->video_file) {
            return 'video';
        }

        if ($this->video_url) {
            return 'youtube';
        }

        return 'image';
    }

    /**
     * Build a YouTube embed URL (autoplay + muted) from a stored video_url.
     */
    public function getEmbedUrlAttribute(): ?string
    {
        $url = $this->video_url;

        if (! $url) {
            return null;
        }

        $videoId = $this->extractYoutubeId($url);

        if (! $videoId) {
            return null;
        }

        $params = http_build_query([
            'autoplay' => 1,
            'mute' => 1,
            'playsinline' => 1,
            'rel' => 0,
            'controls' => 0,
            'showinfo' => 0,
            'modestbranding' => 1,
            'iv_load_policy' => 3,
            'disablekb' => 1,
            'fs' => 0,
            'loop' => 1,
            'playlist' => $videoId,
        ]);

        return 'https://www.youtube-nocookie.com/embed/'.$videoId.'?'.$params;
    }

    /**
     * Extract the YouTube video id from various URL formats.
     */
    protected function extractYoutubeId(string $url): ?string
    {
        $url = trim($url);

        // youtu.be/<id>
        if (preg_match('~youtu\.be/([A-Za-z0-9_-]{11})~', $url, $m)) {
            return $m[1];
        }

        // youtube.com/watch?v=<id>
        if (preg_match('~[?&]v=([A-Za-z0-9_-]{11})~', $url, $m)) {
            return $m[1];
        }

        // youtube.com/embed/<id>, /shorts/<id>, /live/<id>
        if (preg_match('~youtube\.com/(?:embed|shorts|live)/([A-Za-z0-9_-]{11})~', $url, $m)) {
            return $m[1];
        }

        return null;
    }
}
