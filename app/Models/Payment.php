<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'coupon_id',
        'order_id',
        'amount',
        'transaction_status',
        'payment_type',
        'payload',
        'paid_at',
        'status',
        'payment_gateway',
        'gateway_transaction_id',
        'payment_url',
    ];

    protected $casts = [
        'payload' => 'array',
        'paid_at' => 'datetime',
    ];

    /* =====================
     |  RELATIONSHIPS
     ===================== */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    /* =====================
     |  HELPERS
     ===================== */

    public function isPaid(): bool
    {
        return in_array($this->transaction_status, ['settlement', 'capture', 'paid']);
    }

    public function isPending(): bool
    {
        return in_array($this->transaction_status, ['pending']);
    }

    public function isFailed(): bool
    {
        return in_array($this->transaction_status, ['deny', 'expire', 'cancel', 'failure']);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
