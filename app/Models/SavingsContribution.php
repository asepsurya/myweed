<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavingsContribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'savings_goal_id',
        'invitation_id',
        'savings_contributor_id',
        'contributor_id',
        'user_id',
        'amount',
        'currency',
        'method',
        'contributed_at',
        'note',
        'is_automatic',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'contributed_at' => 'datetime',
        'is_automatic' => 'boolean',
    ];

    public function goal(): BelongsTo
    {
        return $this->belongsTo(SavingsGoal::class, 'savings_goal_id');
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function contributor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contributor_id');
    }

    public function savingsContributor(): BelongsTo
    {
        return $this->belongsTo(SavingsContributor::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getMethodNameAttribute(): string
    {
        $map = [
            'transfer' => 'Transfer',
            'e-wallet' => 'E-Wallet',
            'cash' => 'Tunai',
            'card' => 'Kartu',
        ];

        return $map[$this->method] ?? $this->method;
    }

    public function getContributorNameAttribute(): string
    {
        if ($this->savingsContributor) {
            return $this->savingsContributor->name;
        }

        return $this->contributor?->name ?? '-';
    }
}
