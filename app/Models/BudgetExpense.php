<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_category_id',
        'invitation_id',
        'user_id',
        'vendor_name',
        'amount',
        'expense_date',
        'payment_method',
        'description',
        'receipt_path',
        'is_paid',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
        'is_paid' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(BudgetCategory::class, 'budget_category_id');
    }

    public function budget(): BelongsTo
    {
        return $this->category->budget();
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPaymentMethodNameAttribute(): string
    {
        $map = [
            'cash' => 'Tunai',
            'transfer' => 'Transfer',
            'e-wallet' => 'E-Wallet',
            'credit' => 'Kartu Kredit',
            'card' => 'Kartu Debit',
        ];

        return $map[$this->payment_method] ?? $this->payment_method;
    }
}
