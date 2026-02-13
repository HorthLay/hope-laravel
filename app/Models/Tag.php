<?php
// app/Models/Tag.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable = ['name', 'slug', 'color', 'style', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($t) => $t->slug ??= Str::slug($t->name));
        static::updating(function ($t) {
            if ($t->isDirty('name') && !$t->isDirty('slug'))
                $t->slug = Str::slug($t->name);
        });
    }

    // ── Relationships ──────────────────────────────────────────────────────
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────────
    public function scopeActive($q)   { return $q->where('is_active', true); }
    public function scopeOrdered($q)  { return $q->orderBy('name'); }

    // ── Helpers ─────────────────────────────────────────────────────────────
    /**
     * Returns the Tailwind/inline classes for the chosen style.
     * style: pill | outline | solid | soft | minimal
     */
    public function getBadgeClassesAttribute(): string
    {
        return match($this->style) {
            'solid'   => 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-xs font-bold text-white',
            'outline' => 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold border-2 bg-transparent',
            'soft'    => 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-xs font-semibold',
            'minimal' => 'inline-flex items-center gap-1 text-xs font-bold underline underline-offset-2',
            default   => 'inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold',  // pill
        };
    }

    public function getBadgeStyleAttribute(): string
    {
        return match($this->style) {
            'solid'   => "background-color:{$this->color};",
            'outline' => "border-color:{$this->color};color:{$this->color};",
            'soft'    => "background-color:{$this->color}22;color:{$this->color};",
            'minimal' => "color:{$this->color};",
            default   => "background-color:{$this->color}22;color:{$this->color};border:1px solid {$this->color}55;",
        };
    }
}