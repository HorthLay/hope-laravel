<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'sender',          // 'sponsor' | 'admin'
        'body',
        'attachment_path',
        'attachment_name',
        'attachment_size',
        'is_image',        // bool — true when attachment was converted to WebP
        'link_preview',    // JSON — OG metadata when body contains a URL
        'is_edited',       // bool — true when admin edited the message
        'admin_read_at',   // timestamp — when admin read sponsor's message
        'read_at',         // timestamp — when sponsor read admin's message
    ];

    protected $casts = [
        'read_at'        => 'datetime',
        'admin_read_at'  => 'datetime',
        'is_image'       => 'boolean',
        'is_edited'      => 'boolean',
        'link_preview'   => 'array',
    ];

    /* ── Relationships ─────────────────────────────────── */

    public function thread()
    {
        return $this->belongsTo(SponsorMessageThread::class, 'thread_id');
    }

    /* ── Accessors ─────────────────────────────────────── */

    /** True when sponsor hasn't read this admin message yet. */
    public function getIsUnreadBySponsorAttribute(): bool
    {
        return $this->sender === 'admin' && is_null($this->read_at);
    }

    /** True when admin hasn't read this sponsor message yet. */
    public function getIsUnreadByAdminAttribute(): bool
    {
        return $this->sender === 'sponsor' && is_null($this->admin_read_at);
    }

    /** Resolved public URL for the attachment. */
    public function getAttachmentUrlAttribute(): ?string
    {
        return $this->attachment_path ? asset($this->attachment_path) : null;
    }
}