<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildMedia extends Model
{
    use HasFactory;

    protected $fillable = ['child_id', 'type', 'file_path', 'caption', 'taken_date'];

    protected $casts = ['taken_date' => 'date'];

    public function child()
    {
        return $this->belongsTo(SponsoredChild::class, 'child_id');
    }

    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
