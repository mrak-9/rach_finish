<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConferenceThesis extends Model
{
    protected $fillable = [
        'conference_id',
        'user_id',
        'title',
        'description',
        'file_path',
        'is_approved',
        'consent_to_publish',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'consent_to_publish' => 'boolean',
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
