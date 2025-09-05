<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Conference extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'registration_start_date',
        'conference_start_date',
        'conference_end_date',
        'location',
        'conference_type',
        'announcement',
        'description',
        'post_release',
        'important_dates',
        'events',
        'is_active',
        'is_paid',
    ];

    protected function casts(): array
    {
        return [
            'registration_start_date' => 'date',
            'conference_start_date' => 'date',
            'conference_end_date' => 'date',
            'important_dates' => 'array',
            'events' => 'array',
            'is_active' => 'boolean',
            'is_paid' => 'boolean',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($conference) {
            if (empty($conference->slug)) {
                $conference->slug = Str::slug($conference->title);
            }
        });
    }

    public function participants(): HasMany
    {
        return $this->hasMany(ConferenceParticipant::class);
    }

    public function theses(): HasMany
    {
        return $this->hasMany(ConferenceThesis::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCurrent($query)
    {
        return $query->where('conference_start_date', '>=', now()->toDateString());
    }

    public function scopePast($query)
    {
        return $query->where('conference_end_date', '<', now()->toDateString());
    }

    public function isRegistrationOpen(): bool
    {
        return $this->registration_start_date <= now()->toDateString() && 
               $this->conference_start_date >= now()->toDateString();
    }

    public function isFinished(): bool
    {
        $endDate = $this->conference_end_date ?: $this->conference_start_date;
        return $endDate < now()->toDateString();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
