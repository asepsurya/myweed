<?php

namespace App\Models;

use App\Models\Rsvp;
use App\Models\Music;
use App\Models\Gallery;
use App\Models\Template;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
      protected $casts = [
        'custom_data' => 'array',
        'love_story' => 'array',
    ];
    protected $guarded = ['id'];

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
        return $this->belongsTo(Music::class,'music','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createDefault($userId)
    {
        return self::create([
            'user_id' => $userId,
            'template_id' => 1, // Simple Template
            'slug' => 'basic-wedding-' . $userId . '-' . rand(100, 999),
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
