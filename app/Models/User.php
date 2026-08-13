<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSubscribed()
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->subscription &&
            $this->subscription->is_active &&
            $this->subscription->end_date->isFuture();
    }

    public function isPaidSubscribed()
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (! $this->subscription || ! $this->subscription->is_active) {
            return false;
        }

        if ($this->subscription->end_date && ! $this->subscription->end_date->isFuture()) {
            return false;
        }

        return ! $this->subscription->plan->is_free;
    }

    public function hasFeature(string $key): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (! $this->isSubscribed()) {
            return false;
        }

        $plan = $this->subscription->plan;

        return $plan ? $plan->hasFeature($key) : false;
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function partnerIn()
    {
        return $this->hasMany(Invitation::class, 'partner_user_id');
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function savingsGoals()
    {
        return $this->hasMany(SavingsGoal::class);
    }

    public function savingsContributions()
    {
        return $this->hasMany(SavingsContribution::class, 'contributor_id');
    }

    public function canAccessInvitation(Invitation $invitation): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->id === $invitation->user_id
            || ($this->id === $invitation->partner_user_id && $invitation->partner_accepted_at !== null);
    }

    public function subscriptionStatus()
    {
        // ADMIN BYPASS
        if ($this->isAdmin()) {
            return 'active';
        }

        // TIDAK ADA SUBSCRIPTION → FREE
        if (! $this->subscription) {
            return 'free';
        }

        // END DATE NULL (FREE PERMANEN)
        if (is_null($this->subscription->end_date)) {
            return 'active';
        }

        // SUDAH EXPIRED
        if ($this->subscription->end_date->isPast()) {
            return 'expired';
        }

        // MASIH AKTIF
        return 'active';
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
