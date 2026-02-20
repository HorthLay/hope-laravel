<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Sponsor extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
    'first_name',
    'last_name',
    'email',
    'username',
    'password',
    'is_active',
    'last_login_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationship: sponsor has one child
    public function children()
    {
        return $this->belongsToMany(
            SponsoredChild::class,
            'sponsor_sponsored_child',
            'sponsor_id',
            'sponsored_child_id'
        )->withTimestamps();
    }


        public function families()
    {
        return $this->belongsToMany(
            Family::class,
            'sponsor_family',
            'sponsor_id',
            'family_id'
        )->withTimestamps();
    }



    // Helper: full name
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
