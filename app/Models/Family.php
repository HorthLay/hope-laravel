<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'country',
        'story',
        'profile_photo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

       // ── Relationships ────────────────────────────────────────────────

    /** Many-to-many: families are sponsored independently from children */
    public function sponsors()
    {
        return $this->belongsToMany(
            Sponsor::class, 'sponsor_family', 'family_id', 'sponsor_id'
        )->withTimestamps();
    }

    /** Family has its own media (photos/videos), separate from children */
    public function media()
    {
        return $this->hasMany(FamilyMedia::class, 'family_id')
                    ->orderBy('taken_date', 'desc');
    }

    /** Family has its own documents, separate from children */
    public function documents()
    {
        return $this->hasMany(FamilyDocument::class, 'family_id')
                    ->orderBy('document_date', 'desc');
    }

    // ── Accessors ────────────────────────────────────────────────────

    public function getProfilePhotoUrlAttribute(): string
    {
        return $this->profile_photo
            ? asset($this->profile_photo)
            : asset('images/family-placeholder.jpg');
    }

    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    public function articles()
{
    return $this->belongsToMany(
        Article::class,
        'article_family',
        'family_id',
        'article_id'
    )->withTimestamps();
}
    public function members()
{
    return $this->hasMany(FamilyMember::class, 'family_id');
}
}