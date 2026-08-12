<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name', 'slug', 'price', 'duration', 'description', 'is_free', 'features',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function hasFeature(string $key): bool
    {
        $features = $this->features ?? [];

        return (bool) ($features[$key] ?? false);
    }
}
