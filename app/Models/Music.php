<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
      protected $fillable = [
        'title',
        'artist',
        'cover_url',
        'audio_url',
        'category',
        'mood',
        'duration',
        'is_active',
    ];
}
