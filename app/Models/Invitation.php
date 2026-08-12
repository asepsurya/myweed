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
    ];

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'template_id',
        'slug',
        'is_default',
        'status',
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
        'gallery_cover',
        'wedding_quote',
        'video_link',
        'love_story',
        'enable_rsvp',
        'enable_gift',
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
        'partner_user_id',
        'partner_invite_token',
        'partner_accepted_at',
        'partner_can_edit',
    ];

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
}
