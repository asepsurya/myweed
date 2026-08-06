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
<<<<<<< HEAD
        'is_active',
=======
        'views_count',
        'likes_count',
        'category',
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b
    ];
}
