<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'admin_id',
        'image_id',
        'title',
        'slug',
        'style',
        'blocks',
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

    protected $casts = [
        'is_featured' => 'boolean',
        'views_count' => 'integer',
        'published_at' => 'datetime',
    ];

    // ──────────────────────────────────────────────────────────────────────
    //  BOOT — auto-slug + auto-excerpt + auto published_at
    // ──────────────────────────────────────────────────────────────────────
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            // Auto slug
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }

            // Auto excerpt
            if (empty($article->excerpt) && ! empty($article->content)) {
                $article->excerpt = Str::limit(strip_tags($article->content), 200);
            }

            // Auto published_at when creating as published
            if ($article->status === 'published' && empty($article->published_at)) {
                $article->published_at = now();
            }
        });

        static::updating(function ($article) {
            // Regenerate slug only if title changed but slug wasn't manually changed
            if ($article->isDirty('title') && ! $article->isDirty('slug')) {
                $article->slug = Str::slug($article->title);
            }

            // Set published_at when status transitions to published
            if ($article->isDirty('status')
                && $article->status === 'published'
                && empty($article->published_at)) {
                $article->published_at = now();
            }
        });
    }

      public function sponsoredChildren()
    {
        return $this->belongsToMany(
            SponsoredChild::class,
            'article_sponsored_child',
            'article_id',
            'sponsored_child_id'
        )->withTimestamps();
    }

    // family
     public function families()
    {
        return $this->belongsToMany(
            Family::class,
            'article_family',
            'article_id',
            'family_id'
        )->withTimestamps();
    }

    // ──────────────────────────────────────────────────────────────────────
    //  RELATIONSHIPS
    // ──────────────────────────────────────────────────────────────────────
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /** Featured image (direct FK). */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    /** Alias. */
    public function featuredImage()
    {
        return $this->image();
    }

    /** All polymorphic images attached to this article. */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /** Polymorphic images excluding the featured one. */ 
    public function galleryImages()
    {
        return $this->morphMany(Image::class, 'imageable')
            ->where('id', '!=', $this->image_id);
    }

    /** Legacy media. */
    public function media()
    {
        return $this->hasMany(ArticleMedia::class)->orderBy('display_order');
    }

    /** Tags (many-to-many). */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  SCOPES
    // ──────────────────────────────────────────────────────────────────────

    /**
     * Published: status = published.
     * published_at is allowed to be null (treated as "publish immediately").
     * Future-dated articles are still excluded.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            });
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('excerpt', 'like', "%{$term}%")
              ->orWhere('content', 'like', "%{$term}%");
        });
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * scopePopular — order by views descending.
     * NOTE: scopeLatest was removed to avoid conflicting with Eloquent's
     * built-in latest() method (which orders by created_at desc).
     * Use ->orderBy('published_at', 'desc') directly when needed.
     */
    public function scopePopular($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // ──────────────────────────────────────────────────────────────────────
    //  HELPERS / ACCESSORS
    // ──────────────────────────────────────────────────────────────────────
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function isPublished(): bool
    {
        return $this->status === 'published'
            && ($this->published_at === null || $this->published_at <= now());
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        return $this->image
            ? $this->image->url
            : asset('images/default-article.jpg');
    }

    public function getFeaturedImageThumbnailAttribute(): string
    {
        return $this->image
            ? $this->image->thumbnail_url
            : asset('images/default-article.jpg');
    }

    public function getPublishedDateAttribute(): ?string
    {
        return $this->published_at?->format('F j, Y');
    }

    // sponsor 


    public function getReadingTimeAttribute(): int
    {
        $words   = str_word_count(strip_tags($this->content ?? ''));
        $minutes = (int) ceil($words / 200);
        return max(1, $minutes);
    }
}