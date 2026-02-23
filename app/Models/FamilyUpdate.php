<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyUpdate extends Model
{
    use HasFactory;
    protected $fillable = ['family_id', 'title', 'content', 'type', 'report_date'];
    protected $casts    = ['report_date' => 'date'];

    public function family() 
    {
         return $this->belongsTo(Family::class); 
    }
}
