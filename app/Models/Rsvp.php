<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    protected $fillable = [
        'invitation_id',
        'name',
        'message',
        'attending',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
