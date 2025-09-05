<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConferenceParticipant extends Model
{
    protected $fillable = [
        'conference_id',
        'user_id',
        'event_date',
        'participation_format',
        'has_membership',
        'is_approved',
        'organization',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'has_membership' => 'boolean',
            'is_approved' => 'boolean',
        ];
    }

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
}
