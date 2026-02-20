<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildUpdate extends Model
{
    use HasFactory;

    protected $fillable = ['child_id', 'title', 'content', 'type', 'report_date'];

    protected $casts = ['report_date' => 'date'];

    public function child()
    {
        return $this->belongsTo(SponsoredChild::class, 'child_id');
    }
}
