<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'sender',
        'body',
        'attachment_path',
        'attachment_name',
        'attachment_size',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function thread()
    {
        return $this->belongsTo(SponsorMessageThread::class, 'thread_id');
    }

    // Accessor: check if message is unread (for sponsor side)
    public function getIsUnreadAttribute(): bool
    {
        return $this->sender !== 'sponsor' && is_null($this->read_at);
    }
}