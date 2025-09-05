<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Publication extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'published_at',
        'cover_image',
        'files',
        'requires_membership',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'date',
            'files' => 'array',
            'requires_membership' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($publication) {
            if (empty($publication->slug)) {
                $publication->slug = Str::slug($publication->title);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
