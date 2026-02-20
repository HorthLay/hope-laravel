<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildDocument extends Model
{
    use HasFactory;

    protected $fillable = ['child_id', 'title', 'type', 'file_path', 'document_date'];

    protected $casts = ['document_date' => 'date'];

    public function child()
    {
        return $this->belongsTo(SponsoredChild::class, 'child_id');
    }

    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
