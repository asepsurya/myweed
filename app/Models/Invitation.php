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

    protected $fillable = [
        'user_id',
        'template_id',
        'slug',
        'is_default',
        'groom_name',
        'groom_nickname',
        'groom_father_name',
        'groom_mother_name',
        'foto_pria',
        'foto_wanita',
        'bride_name',
        'bride_nickname',
        'bride_father_name',
        'bride_mother_name',
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
        return $this->belongsTo(Music::class,'music','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
