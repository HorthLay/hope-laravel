<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file_name',
        'file_path',
        'thumbnail_path',
        'file_size',
        'mime_type',
        'width',
        'height',
        'alt_text',
        'title',
        'imageable_type',
        'imageable_id',
    ];

    /**
     * Get the parent imageable model (Article, etc).
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * Get the URL for the image.
     */
    public function getUrlAttribute()
    {
        return asset($this->file_path);
    }

    /**
     * Get the thumbnail URL for the image.
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_path ? asset($this->thumbnail_path) : asset($this->file_path);
    }

    /**
     * Get formatted file size.
     */
    public function getFileSizeFormattedAttribute()
    {
        if (!$this->file_size) {
            return 'Unknown';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }
}