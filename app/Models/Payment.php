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
        'proof_image',
        'payment_method',
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

    public function paymentMethodLabel(): string
    {
        if ($this->payment_gateway === 'local') {
            return 'QRIS (Pembayaran Lokal)';
        }

        return match($this->payment_type) {
            'credit_card' => 'Kartu Kredit',
            'bank_transfer' => 'Transfer Bank',
            'echannel' => 'E-Channel / Mandiri Bill',
            'gopay' => 'GoPay',
            'shopeepay' => 'ShopeePay',
            'qris' => 'QRIS',
            'cimb_clicks' => 'CIMB Clicks',
            'bca_klikpay' => 'BCA KlikPay',
            'bca_va' => 'BCA Virtual Account',
            'bni_va' => 'BNI Virtual Account',
            'bri_va' => 'BRI Virtual Account',
            'permata_va' => 'Permata Virtual Account',
            'other_va' => 'Virtual Account',
            'indomaret' => 'Indomaret',
            'alfamart' => 'Alfamart',
            'akulaku' => 'Akulaku',
            'keluarga_sehat' => 'Keluarga Sehat',
            'mitra_bca' => 'Mitra BCA',
            default => ucfirst(str_replace('_', ' ', $this->payment_type ?? $this->payment_gateway ?? 'Midtrans'))
        };
    }
}
