<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'user_id',
        'title',
        'total_amount',
        'currency',
        'status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(BudgetCategory::class)->orderBy('sort_order');
    }

    public function expenses(): HasManyThrough
    {
        return $this->hasManyThrough(BudgetExpense::class, BudgetCategory::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(VendorPayment::class, 'invitation_id', 'invitation_id');
    }

    public function spentAmount(): float
    {
        return (float) $this->expenses()->sum('amount');
    }

    public function remainingAmount(): float
    {
        return (float) $this->total_amount - $this->spentAmount();
    }

    public function usagePercent(): float
    {
        if ($this->total_amount == 0) {
            return 0;
        }

        return round(($this->spentAmount() / $this->total_amount) * 100, 1);
    }

    public function isOverBudget(): bool
    {
        return $this->spentAmount() > $this->total_amount;
    }
}
