<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Membership extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'start_date',
        'end_date',
        'status',
        'payment_id',
        'payment_data',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'payment_data' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'paid')
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    public function isActive(): bool
    {
        return $this->status === 'paid' && 
               $this->start_date <= now() && 
               $this->end_date >= now();
    }
}
