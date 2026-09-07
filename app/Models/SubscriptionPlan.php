<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug', 'price', 'original_price', 'badge_text', 'duration', 'description', 'is_free', 'features', 'invitation_limit', 'template_type_access',
    ];

    protected $casts = [
        'features' => 'array',
        'duration' => 'integer',
        'price' => 'integer',
        'original_price' => 'integer',
        'is_free' => 'boolean',
        'invitation_limit' => 'integer',
        'template_type_access' => 'integer',
    ];

    public function hasFeature(string $key): bool
    {
        $features = $this->features ?? [];

        return (bool) ($features[$key] ?? false);
    }

    public function maxAccessibleTemplateTypeId(): int
    {
        if ($this->is_free) {
            return 1;
        }

        if ($this->template_type_access) {
            return (int) $this->template_type_access;
        }

        if ($this->slug === 'pro') {
            return 3;
        }

        if ($this->slug === 'basic' || $this->hasFeature('all_themes')) {
            return 2;
        }

        return 1;
    }
}
