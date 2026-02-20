<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMedia extends Model
{
    protected $fillable = ['family_id', 'file_path', 'type', 'caption', 'taken_date'];
    protected $casts    = ['taken_date' => 'date'];

    public function family() { return $this->belongsTo(Family::class); }

    public function getFileUrlAttribute(): string
    {
        return asset($this->file_path);
    }
}
