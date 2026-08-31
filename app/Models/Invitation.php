<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $casts = [
        'custom_data' => 'array',
        'love_story' => 'array',
        'expired_at' => 'datetime',
        'retention_until' => 'datetime',
        'deletion_started_at' => 'datetime',
        'deletion_completed_at' => 'datetime',
    ];

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_EXPIRED = 'expired';
    const STATUS_TRASH = 'trash';

    const LIFECYCLE_STATUSES = [
        self::STATUS_DRAFT,
        self::STATUS_PUBLISHED,
        self::STATUS_EXPIRED,
        self::STATUS_TRASH,
    ];

    const RETENTION_DAYS = 7;
    const MAX_DELETION_ATTEMPTS = 5;

    protected $fillable = [
        'user_id',
        'template_id',
        'public_id',
        'slug',
        'is_default',
        'status',
        'expired_at',
        'retention_until',
        'deletion_started_at',
        'deletion_completed_at',
        'deletion_attempts',
        'deletion_error',
        'primary_color',
        'groom_name',
        'groom_nickname',
        'groom_father_name',
        'groom_mother_name',
        'groom_child_order',
        'foto_pria',
        'foto_wanita',
        'bride_name',
        'bride_nickname',
        'bride_father_name',
        'bride_mother_name',
        'bride_child_order',
        'wedding_date',
        'akad_location',
        'akad_time',
        'akad_time_end',
        'akad_maps',
        'resepsi_location',
        'resepsi_time',
        'resepsi_time_end',
        'resepsi_maps',
        'theme_color',
        'theme_type',
        'gallery_cover',
                'wedding_quote',
                'quote_id',
                'video_link',
        'love_story',
        'enable_rsvp',
        'enable_gift',
        'enable_gallery',
        'enable_music',
        'enable_video',
        'enable_love_story',
        'groom_instagram',
        'groom_username_instagram',
        'bride_instagram',
        'bride_username_instagram',
        'akad_address',
        'resepsi_address',
        'rsvp_deadline',
        'rsvp_message',
        'rsvp_whatsapp',
        'music',
        'music_youtube_url',
        'music_youtube_cover',
        'partner_user_id',
        'partner_invite_token',
        'partner_accepted_at',
        'partner_can_edit',
    ];

    protected static function booted()
    {
        static::creating(function ($invitation) {
            if (empty($invitation->public_id)) {
                $invitation->public_id = static::generatePublicId();
            }
        });
    }

    public static function generatePublicId(int $length = 21): string
    {
        return nanoid($length);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return static::where('public_id', $value)->orWhere('id', $value)->first();
    }

    public function getRouteKeyName(): string
    {
        return 'public_id';
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }

    public function gifts()
    {
        return $this->hasMany(Gift::class);
    }

    public function musicPreset()
    {
        return $this->belongsTo(Music::class, 'music', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_user_id');
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function savingsGoals()
    {
        return $this->hasMany(SavingsGoal::class);
    }

    public function getGroomChildOrderTextAttribute()
    {
        return $this->childOrderText($this->groom_child_order);
    }

    public function getBrideChildOrderTextAttribute()
    {
        return $this->childOrderText($this->bride_child_order);
    }

    private function childOrderText($value)
    {
        if (empty($value)) {
            return '';
        }

        if ($value === 'Anak pertama') {
            return 'Pertama';
        }

        if (preg_match('/^Anak ke-(\d+)$/', $value, $match)) {
            $num = (int) $match[1];
            $map = [
                1 => 'Pertama', 2 => 'Kedua', 3 => 'Ketiga', 4 => 'Keempat',
                5 => 'Kelima', 6 => 'Keenam', 7 => 'Ketujuh', 8 => 'Kedelapan',
                9 => 'Kesembilan', 10 => 'Kesepuluh', 11 => 'Kesebelas',
            ];

            return $map[$num] ?? 'Ke-'.$num;
        }

        return $value;
    }

    public static function createDefault($userId)
    {
        return self::create([
            'user_id' => $userId,
            'template_id' => 1, // Simple Template
            'public_id' => self::generatePublicId(),
            'slug' => 'basic-wedding-'.$userId.'-'.rand(100, 999),
            'groom_name' => 'Mempelai Pria',
            'bride_name' => 'Mempelai Wanita',
            'wedding_date' => now()->addMonths(3)->format('Y-m-d'),
            'status' => 'draft',
            'wedding_quote' => 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
            'akad_location' => 'Masjid Raya',
            'akad_time' => '08:00:00',
            'resepsi_location' => 'Gedung Serbaguna',
            'resepsi_time' => '11:00:00',
        ]);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', self::STATUS_EXPIRED);
    }

    public function scopeTrash($query)
    {
        return $query->where('status', self::STATUS_TRASH);
    }

    public function scopeScheduledForDeletion($query)
    {
        return $query->where('status', self::STATUS_TRASH)
            ->whereNotNull('retention_until')
            ->where('retention_until', '<=', now());
    }

    public function scopeEligibleForExpiration($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED)
            ->whereHas('user', function ($q) {
                $q->whereDoesntHave('subscription', function ($sq) {
                    $sq->where('is_active', true)
                        ->where(function ($sq2) {
                            $sq2->whereNull('end_date')
                                ->orWhere('end_date', '>', now());
                        });
                });
            });
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED;
    }

    public function isTrash(): bool
    {
        return $this->status === self::STATUS_TRASH;
    }

    public function isScheduledForDeletion(): bool
    {
        return $this->isTrash() && $this->retention_until !== null && $this->retention_until->isPast();
    }

    public function canBeRestored(): bool
    {
        if (! $this->user) {
            return false;
        }

        return $this->isExpired() || $this->isTrash();
    }

    public function markAsExpired(): bool
    {
        if (! $this->isActive()) {
            return false;
        }

        $this->status = self::STATUS_EXPIRED;
        $this->expired_at = now();
        $this->retention_until = now()->addDays(self::RETENTION_DAYS);

        return $this->save();
    }

    public function restore(): bool
    {
        if (! $this->canBeRestored()) {
            return false;
        }

        $this->status = self::STATUS_PUBLISHED;
        $this->expired_at = null;
        $this->retention_until = null;
        $this->deletion_started_at = null;
        $this->deletion_completed_at = null;
        $this->deletion_attempts = 0;
        $this->deletion_error = null;

        return $this->save();
    }
}
