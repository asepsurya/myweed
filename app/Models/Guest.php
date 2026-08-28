<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'name',
        'phone',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
