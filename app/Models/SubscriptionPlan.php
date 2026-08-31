<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug', 'price', 'original_price', 'badge_text', 'duration', 'description', 'is_free', 'features', 'invitation_limit',
    ];

    protected $casts = [
        'features' => 'array',
        'duration' => 'integer',
        'price' => 'integer',
        'original_price' => 'integer',
        'is_free' => 'boolean',
        'invitation_limit' => 'integer',
    ];

    public function hasFeature(string $key): bool
    {
        $features = $this->features ?? [];

        return (bool) ($features[$key] ?? false);
    }
}
