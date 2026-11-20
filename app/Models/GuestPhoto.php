<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestPhoto extends Model
{
    // The guest_photos table only has a created_at column.
    const UPDATED_AT = null;

    protected $fillable = [
        'event_id',
        'guest_name',
        'device_id',
        'image_url',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class, 'event_id');
    }
}