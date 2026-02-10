<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'file_size' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
    ];

    /**
     * Get the parent imageable model (polymorphic).
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * Get all articles that use this image as featured image.
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Get the full URL of the image.
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    /**
     * Get the full URL of the thumbnail.
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_path ? Storage::url($this->thumbnail_path) : $this->url;
    }

    /**
     * Get the file size in human readable format.
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }

    /**
     * Get image dimensions as string.
     */
    public function getDimensionsAttribute()
    {
        if ($this->width && $this->height) {
            return "{$this->width} × {$this->height} px";
        }
        return null;
    }

    /**
     * Check if image is portrait orientation.
     */
    public function isPortrait(): bool
    {
        if (!$this->width || !$this->height) {
            return false;
        }
        return $this->height > $this->width;
    }

    /**
     * Check if image is landscape orientation.
     */
    public function isLandscape(): bool
    {
        if (!$this->width || !$this->height) {
            return false;
        }
        return $this->width > $this->height;
    }

    /**
     * Check if image is square.
     */
    public function isSquare(): bool
    {
        if (!$this->width || !$this->height) {
            return false;
        }
        return $this->width === $this->height;
    }

    /**
     * Scope a query to search images by name.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('file_name', 'like', "%{$term}%")
            ->orWhere('alt_text', 'like', "%{$term}%")
            ->orWhere('title', 'like', "%{$term}%");
    }

    /**
     * Delete the image file from storage when model is deleted.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($image) {
            // Delete main image
            if (Storage::disk('public')->exists($image->file_path)) {
                Storage::disk('public')->delete($image->file_path);
            }

            // Delete thumbnail
            if ($image->thumbnail_path && Storage::disk('public')->exists($image->thumbnail_path)) {
                Storage::disk('public')->delete($image->thumbnail_path);
            }
        });
    }
}