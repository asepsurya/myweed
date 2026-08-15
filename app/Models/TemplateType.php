<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TemplateType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'color',
    ];

    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
    }
}
