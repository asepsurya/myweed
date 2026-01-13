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
        'custom_data' => 'array'
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
     public function musicPreset()
    {
        return $this->belongsTo(Music::class,'music','id');
    }
}
