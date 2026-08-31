<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class YoutubeMusic extends Model
{
    protected $fillable = [
        'title',
        'artist',
        'youtube_url',
        'youtube_id',
        'cover_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class, 'music_youtube_url', 'youtube_url');
    }
}
