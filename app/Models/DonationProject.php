<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationProject extends Model
{
    protected $fillable = [
        'title_en', 'title_fr', 'title_km',
        'description_en', 'description_fr', 'description_km',
        'image',
        'helloasso_widget_url', 'helloasso_counter_url', 'helloasso_vignette_url',
        'tags', 'badge_label', 'badge_color',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'tags'      => 'array',
        'is_active' => 'boolean',
    ];

    // ── Scopes ──────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    // ── Accessors ───────────────────────────────────
    public function getTitleAttribute(): string
    {
        $lang = app()->getLocale();
        return $this->{"title_{$lang}"} ?? $this->title_fr ?? $this->title_en ?? '';
    }

    public function getDescriptionAttribute(): string
    {
        $lang = app()->getLocale();
        return $this->{"description_{$lang}"} ?? $this->description_fr ?? $this->description_en ?? '';
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) return asset('images/children/image-1.jpg');
        return Str::startsWith($this->image, ['http://', 'https://'])
            ? $this->image
            : asset($this->image);
    }

    public function getBadgeColorClassAttribute(): string
    {
        return match($this->badge_color) {
            'green' => 'background:rgba(34,197,94,.9)',
            'blue'  => 'background:rgba(59,130,246,.9)',
            'gray'  => 'background:rgba(100,116,139,.9)',
            default => 'background:rgba(249,115,22,.95)',
        };
    }
}