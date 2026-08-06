<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $casts = [
        'sections' => 'array',
    ];

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'preview',
        'sections',
        'is_active',
        'views_count',
        'likes_count',
        'category',
        'is_premium',
        'primary_color',
    ];
}
