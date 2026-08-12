<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'name',
        'colour',
        'allocated_amount',
        'note',
        'sort_order',
    ];

    protected $casts = [
        'allocated_amount' => 'decimal:2',
        'colour' => 'string',
        'note' => 'string',
    ];

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(BudgetExpense::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(VendorPayment::class);
    }

    public function spentAmount(): float
    {
        return (float) $this->expenses()->sum('amount');
    }

    public function remainingAmount(): float
    {
        return (float) $this->allocated_amount - $this->spentAmount();
    }

    public function usagePercent(): float
    {
        if ($this->allocated_amount == 0) {
            return 0;
        }

        return round(($this->spentAmount() / $this->allocated_amount) * 100, 1);
    }

    public function isOverBudget(): bool
    {
        return $this->spentAmount() > $this->allocated_amount;
    }
}
