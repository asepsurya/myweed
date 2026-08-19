<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class SavingsContributor extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'invitation_id',
        'user_id',
        'name',
        'email',
        'relationship',
        'is_external',
        'invite_token',
        'invite_email',
        'invited_at',
        'accepted_at',
        'can_edit',
    ];

    protected $casts = [
        'is_external' => 'boolean',
        'can_edit' => 'boolean',
        'invited_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contributions(): HasMany
    {
        return $this->hasMany(SavingsContribution::class);
    }
}
