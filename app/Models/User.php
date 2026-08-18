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
        'phone',
        'google_id',
        'avatar',
        'role',
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

        if ($this->subscription &&
            $this->subscription->is_active &&
            $this->subscription->end_date->isFuture()
        ) {
            return true;
        }

        $partnerInvitations = $this->partnerIn()
            ->whereNotNull('partner_accepted_at')
            ->with('user.subscription')
            ->get();

        foreach ($partnerInvitations as $invitation) {
            $owner = $invitation->user;

            if ($owner && $owner->isAdmin()) {
                return true;
            }

            if ($owner && $owner->subscription &&
                $owner->subscription->is_active &&
                $owner->subscription->end_date->isFuture()
            ) {
                return true;
            }
        }

        return false;
    }

    public function isPaidSubscribed()
    {
        if ($this->isAdmin()) {
            return true;
        }

        if ($this->subscription && $this->subscription->is_active && $this->subscription->end_date && $this->subscription->end_date->isFuture() && !$this->subscription->plan->is_free) {
            return true;
        }

        $partnerInvitations = $this->partnerIn()
            ->whereNotNull('partner_accepted_at')
            ->with('user.subscription.plan')
            ->get();

        foreach ($partnerInvitations as $invitation) {
            $owner = $invitation->user;

            if ($owner && $owner->isAdmin()) {
                return true;
            }

            if ($owner && $owner->subscription && $owner->subscription->is_active && $owner->subscription->end_date && $owner->subscription->end_date->isFuture() && !$owner->subscription->plan->is_free) {
                return true;
            }
        }

        return false;
    }

    public function hasFeature(string $key): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if ($this->isSubscribed() && $this->subscription) {
            $plan = $this->subscription->plan;

            if ($plan && $plan->hasFeature($key)) {
                return true;
            }
        }

        $partnerInvitations = $this->partnerIn()
            ->whereNotNull('partner_accepted_at')
            ->with('user.subscription.plan')
            ->get();

        foreach ($partnerInvitations as $invitation) {
            $owner = $invitation->user;

            if ($owner && $owner->isAdmin()) {
                return true;
            }

            if ($owner && !$owner->isAdmin() && $owner->isSubscribed() && $owner->subscription) {
                $plan = $owner->subscription->plan;

                if ($plan && $plan->hasFeature($key)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getPartnerSubscriptionOwner(): ?User
    {
        if ($this->subscription && $this->subscription->is_active && $this->subscription->end_date && $this->subscription->end_date->isFuture() && !$this->subscription->plan->is_free) {
            return null;
        }

        $partnerInvitations = $this->partnerIn()
            ->whereNotNull('partner_accepted_at')
            ->with('user.subscription.plan')
            ->get();

        foreach ($partnerInvitations as $invitation) {
            $owner = $invitation->user;

            if ($owner && $owner->isAdmin()) {
                return $owner;
            }

            if ($owner && $owner->isSubscribed() && $owner->subscription && $owner->subscription->plan && !$owner->subscription->plan->is_free) {
                return $owner;
            }
        }

        return null;
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
            $partnerOwner = $this->getPartnerSubscriptionOwner();
            if ($partnerOwner) {
                return 'active';
            }
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
