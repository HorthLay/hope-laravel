<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
   use HasFactory;

    protected $fillable = [
        'family_id',
        'name',
        'relationship',
        'phone',
        'email',
        'profile_photo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
