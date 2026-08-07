<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Music extends Model
{
    protected $fillable = [
        'title',
        'artist',
        'album',
        'cover_url',
        'audio_url',
        'music_url',
        'duration',
        'file_size',
        'mime_type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'file_size' => 'integer',
    ];

    public function getMusicUrlAttribute()
    {
        return $this->attributes['music_url'] ?: $this->attributes['audio_url'];
    }

    public function getFullAudioUrlAttribute()
    {
        $url = $this->attributes['music_url'] ?: $this->attributes['audio_url'];
        if (!$url) return null;
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }

        $disk = config('music.disk', 'r2');

        if ($disk === 'local' || $disk === 'public') {
            return asset('storage/' . $url);
        }

        return Storage::disk($disk)->url($url);
    }

    public function getFullCoverUrlAttribute()
    {
        if (!$this->cover_url) return null;
        if (filter_var($this->cover_url, FILTER_VALIDATE_URL)) {
            return $this->cover_url;
        }

        $disk = config('music.disk', 'r2');

        if ($disk === 'local' || $disk === 'public') {
            return asset('storage/' . $this->cover_url);
        }

        return Storage::disk($disk)->url($this->cover_url);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class, 'music', 'id');
    }
}
