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
        'cover_url',
        'audio_url',
        'music_url',
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
        return $this->attributes['music_url'] ?? $this->attributes['audio_url'] ?? null;
    }

    public function getFullAudioUrlAttribute()
    {
        $url = $this->attributes['music_url'] ?? $this->attributes['audio_url'] ?? null;
        if (!$url) return null;
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }
        return Storage::disk('public')->url($url);
    }

    public function getFullCoverUrlAttribute()
    {
        if (!$this->cover_url) return null;
        if (filter_var($this->cover_url, FILTER_VALIDATE_URL)) {
            return $this->cover_url;
        }

        return Storage::disk('public')->url($this->cover_url);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class, 'music', 'id');
    }
}
