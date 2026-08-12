<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SavingsGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'user_id',
        'name',
        'target_amount',
        'currency',
        'deadline',
        'colour',
        'description',
        'auto_savings_rule',
        'is_active',
        'is_shared',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'deadline' => 'date',
        'auto_savings_rule' => 'array',
        'is_active' => 'boolean',
        'is_shared' => 'boolean',
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

    public function totalSaved(): float
    {
        return (float) $this->contributions()->sum('amount');
    }

    public function remainingAmount(): float
    {
        return (float) $this->target_amount - $this->totalSaved();
    }

    public function progressPercent(): float
    {
        if ($this->target_amount == 0) {
            return 0;
        }

        return min(100, round(($this->totalSaved() / $this->target_amount) * 100, 1));
    }

    public function daysRemaining(): int
    {
        return (int) now()->startOfDay()->diffInDays(Carbon::parse($this->deadline));
    }

    public function dailyRequired(): float
    {
        $days = $this->daysRemaining();
        if ($days <= 0 || $this->remainingAmount() <= 0) {
            return 0;
        }

        return round($this->remainingAmount() / $days, 2);
    }

    public function isOnTrack(): bool
    {
        $days = $this->daysRemaining();
        if ($days <= 0) {
            return $this->progressPercent() >= 100;
        }

        $requiredTotal = $this->dailyRequired() * $days;

        return $this->totalSaved() >= $requiredTotal;
    }

    public function milestone(): ?string
    {
        $pct = $this->progressPercent();

        return match (true) {
            $pct >= 100 => 'complete',
            $pct >= 90 => '90_percent',
            $pct >= 75 => '75_percent',
            $pct >= 50 => '50_percent',
            default => null,
        };
    }
}
