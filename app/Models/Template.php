<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Template extends Model
{
    protected $casts = [
        'sections' => 'array',
        'ai_prompt' => 'array',
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
        'id_category',
        'is_premium',
        'primary_color',
        'user_id',
        'is_user_template',
        'parent_template',
        'ai_prompt',
        'description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function scopePublic($query)
    {
        return $query->where(function ($q) {
            $q->where('is_user_template', false)
              ->orWhere(function ($q2) {
                  $q2->where('is_user_template', true)
                     ->where('user_id', auth()->id());
              });
        });
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('is_user_template', false)
              ->orWhere('user_id', $userId);
        });
    }

    public function isOwnedBy($userId): bool
    {
        return $this->user_id === $userId;
    }
}
