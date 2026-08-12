<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'budget_category_id',
        'user_id',
        'vendor_name',
        'vendor_contact',
        'amount',
        'currency',
        'scheduled_date',
        'due_date',
        'paid_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'scheduled_date' => 'date',
        'due_date' => 'date',
        'paid_at' => 'datetime',
    ];

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BudgetCategory::class, 'budget_category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'scheduled' => 'Terjadwal',
            'paid' => 'Dibayar',
            'overdue' => 'Terlambat',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'paid' => 'bg-success-subtle text-success border border-success-subtle',
            'scheduled' => 'bg-warning-subtle text-warning border border-warning-subtle',
            'overdue' => 'bg-danger-subtle text-danger border border-danger-subtle',
            'cancelled' => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
            default => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
        };
    }

    public function isOverdue(): bool
    {
        if ($this->status === 'paid' || $this->status === 'cancelled' || ! $this->scheduled_date) {
            return false;
        }

        return Carbon::parse($this->scheduled_date)->isPast();
    }

    public function daysUntilDue(): ?int
    {
        if (! $this->scheduled_date) {
            return null;
        }

        return (int) now()->startOfDay()->diffInDays(Carbon::parse($this->scheduled_date));
    }
}
