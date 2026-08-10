<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'icon'];

    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
        'icon' => 'string',
    ];

    public function templates(): HasMany
    {
        return $this->hasMany(Template::class, 'id_category');
    }
}
