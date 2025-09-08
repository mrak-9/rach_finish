<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'region',
        'phone',
        'email',
        'address',
        'short_description',
        'description',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($branch) {
            if (empty($branch->slug)) {
                $branch->slug = Str::slug($branch->name);
            }
        });
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    // Events are managed through file system, not database
    // public function events(): BelongsToMany
    // {
    //     return $this->belongsToMany(Event::class, 'branch_event', 'branch_id', 'event_name', 'id', 'name');
    // }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
