<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorMessageThread extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsor_id',
        'entity_type',
        'entity_id',
        'subject',
    ];

    public function messages()
    {
        return $this->hasMany(SponsorMessage::class, 'thread_id')
                    ->orderBy('created_at', 'asc');
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    // Efficient unread count
    public function getUnreadCountAttribute(): int
    {
        // If already loaded, avoid extra query
        if ($this->relationLoaded('messages')) {
            return $this->messages
                ->where('sender', '!=', 'sponsor')
                ->whereNull('read_at')
                ->count();
        }

        return $this->messages()
            ->where('sender', '!=', 'sponsor')
            ->whereNull('read_at')
            ->count();
    }
}