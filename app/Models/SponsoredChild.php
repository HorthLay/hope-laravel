<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsoredChild extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'code',
        'birth_year',
        'story',
        'profile_photo',
        'country',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // article
public function articles()
{
    return $this->belongsToMany(
        Article::class,
        'article_sponsored_child',
        'sponsored_child_id',
        'article_id'
    )->withTimestamps();
}
    // Relationships
public function sponsors()
{
    return $this->belongsToMany(
        Sponsor::class,
        'sponsor_sponsored_child',
        'sponsored_child_id',
        'sponsor_id'
    )->withTimestamps();
}

    public function updates()
    {
        return $this->hasMany(ChildUpdate::class, 'child_id')->orderBy('report_date', 'desc');
    }

    public function media()
    {
        return $this->hasMany(ChildMedia::class, 'child_id')->orderBy('taken_date', 'desc');
    }

    public function documents()
    {
        return $this->hasMany(ChildDocument::class, 'child_id')->orderBy('document_date', 'desc');
    }

    // Helper: age
    public function getAgeAttribute()
    {
        return now()->year - $this->birth_year;
    }

    // Helper: profile photo URL
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo
            ? asset('storage/' . $this->profile_photo)
            : asset('images/child-placeholder.jpg');
    }
}
