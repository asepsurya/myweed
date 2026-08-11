<?php

namespace App\Models;

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

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
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
}
