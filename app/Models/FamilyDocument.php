<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyDocument extends Model
{
     protected $fillable = ['family_id', 'title', 'file_path', 'type', 'document_date'];
    protected $casts    = ['document_date' => 'date'];

    public function family() { return $this->belongsTo(Family::class); }
}
