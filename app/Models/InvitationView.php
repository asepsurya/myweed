<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationView extends Model
{
    protected $fillable = [
        'invitation_id',
        'visitor_hash',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}