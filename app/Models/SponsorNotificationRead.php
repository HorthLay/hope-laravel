<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorNotificationRead extends Model
{
   public $timestamps = false; // only created_at, handled by useCurrent()
 
    protected $fillable = [
        'sponsor_id',
        'notifiable_type', // child_update | family_update | child_document | family_document
        'notifiable_id',
    ];
 
    protected $casts = [
        'created_at' => 'datetime',
    ];
 
    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }
}
