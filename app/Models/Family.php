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

    /**
     * Children reached through FamilyMember.
     * Family → FamilyMember (family_id) → SponsoredChild (family_member_id)
     *
     * hasManyThrough(
     *   final model,           ← SponsoredChild
     *   intermediate model,    ← FamilyMember
     *   foreignKey on FamilyMember pointing to Family,    ← 'family_id'
     *   foreignKey on SponsoredChild pointing to FamilyMember ← 'family_member_id'
     * )
     */
    public function children()
    {
        return $this->hasManyThrough(
            SponsoredChild::class,
            FamilyMember::class,
            'family_id',        // FK on family_members → families
            'family_member_id'  // FK on sponsored_children → family_members
        );
    }

    public function updates()
    {
        return $this->hasMany(FamilyUpdate::class, 'family_id')
                    ->orderBy('report_date', 'desc');
    }

    /** Active children only */
    public function activeChildren()
    {
        return $this->hasManyThrough(
            SponsoredChild::class,
            FamilyMember::class,
            'family_id',
            'family_member_id'
        )->where('sponsored_children.is_active', true);
    }

    /** All family members (parents, guardians, etc.) */
    public function members()
    {
        return $this->hasMany(FamilyMember::class, 'family_id');
    }

    /** Active family members ordered by relationship */
    public function activeMembers()
    {
        return $this->hasMany(FamilyMember::class, 'family_id')
                    ->where('is_active', true)
                    ->orderBy('relationship');
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

    /** Articles associated with this family */
    public function articles()
    {
        return $this->belongsToMany(
            Article::class,
            'article_family',
            'family_id',
            'article_id'
        )->withTimestamps();
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
}