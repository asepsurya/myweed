<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'thumbnail',
        'description',
        'sort_order',
        'is_active',
        'dynamic_fields',
    ];

    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
        'icon' => 'string',
        'thumbnail' => 'string',
        'description' => 'string',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'dynamic_fields' => 'array',
    ];

    public function templates(): HasMany
    {
        return $this->hasMany(Template::class, 'id_category');
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }

    public function getDynamicFieldsAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }

        return is_array($value) ? $value : [];
    }

    public function getThumbnailUrlAttribute()
    {
        if (! $this->thumbnail) {
            return null;
        }

        return Storage::url($this->thumbnail);
    }

    public function templateCount(): int
    {
        return $this->templates()->where('is_active', true)->count();
    }
}
