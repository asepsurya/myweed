<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeedingPlan extends Model
{
    protected $fillable = [
        'user_id',
        'invitation_id',
        'task_name',
        'description',
        'category',
        'due_date',
        'status',
        'priority',
        'notes',
        'completed_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', '!=', 'completed')
            ->where('due_date', '<', now()->toDateString());
    }

    public function isOverdue(): bool
    {
        if ($this->status === 'completed' || !$this->due_date) {
            return false;
        }

        return \Carbon\Carbon::parse($this->due_date)->isPast();
    }
}
