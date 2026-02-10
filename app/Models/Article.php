<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'admin_id',
        'image_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'video_url',
        'status',
        'is_featured',
        'views_count',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_featured' => 'boolean',
        'views_count' => 'integer',
        'published_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
            
            // Auto-generate excerpt if not provided
            if (empty($article->excerpt) && !empty($article->content)) {
                $article->excerpt = Str::limit(strip_tags($article->content), 200);
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('title') && !$article->isDirty('slug')) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    /**
     * Get the category that owns the article.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the admin that owns the article.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get the featured image for the article.
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * Get the featured image (alias).
     */
    public function featuredImage()
    {
        return $this->image();
    }

    /**
     * Get all images for this article (polymorphic).
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Get gallery images (excluding featured image).
     */
    public function galleryImages()
    {
        return $this->morphMany(Image::class, 'imageable')
            ->where('id', '!=', $this->image_id);
    }

    /**
     * Get the media for the article (legacy support).
     */
    public function media()
    {
        return $this->hasMany(ArticleMedia::class)->orderBy('display_order');
    }

    /**
     * Increment the view count.
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Check if article is published.
     */
    public function isPublished(): bool
    {
        return $this->status === 'published' 
            && $this->published_at !== null 
            && $this->published_at <= now();
    }

    /**
     * Check if article is draft.
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Get featured image URL with fallback.
     */
    public function getFeaturedImageUrlAttribute()
    {
        return $this->image ? $this->image->url : asset('images/default-article.jpg');
    }

    /**
     * Get featured image thumbnail URL with fallback.
     */
    public function getFeaturedImageThumbnailAttribute()
    {
        return $this->image ? $this->image->thumbnail_url : asset('images/default-article.jpg');
    }

    /**
     * Scope a query to only include published articles.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include draft articles.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope a query to only include featured articles.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to search articles.
     */
    public function scopeSearch($query, $term)
    {
        return $query->whereFullText(['title', 'content', 'excerpt'], $term);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope a query to order by latest.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Scope a query to order by most viewed.
     */
    public function scopePopular($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the formatted published date.
     */
    public function getPublishedDateAttribute()
    {
        return $this->published_at?->format('F j, Y');
    }

    /**
     * Get the reading time in minutes.
     */
    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200); // Average reading speed
        return $minutes;
    }
}