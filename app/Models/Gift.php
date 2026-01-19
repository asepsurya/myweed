<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
     protected $fillable = [
        'invitation_id',
        'bank',
        'number',
        'name',
        'qr'
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
