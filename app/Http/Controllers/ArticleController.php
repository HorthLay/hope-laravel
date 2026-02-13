<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use App\Models\Category;
use App\Models\Tag;

class ArticleController extends Controller
{
     // ─────────────────────────────────────────────────────────────────
    //  INDEX
    // ─────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Article::with(['category', 'admin', 'image', 'tags']);

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($sq) =>
                $sq->where('title', 'like', "%{$q}%")
                   ->orWhere('content', 'like', "%{$q}%")
            );
        }

        if ($request->filled('status'))   $query->where('status', $request->status);
        if ($request->filled('category')) $query->where('category_id', $request->category);

        $articles   = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    // ─────────────────────────────────────────────────────────────────
    //  CREATE
    // ─────────────────────────────────────────────────────────────────
    public function create()
    {
        $categories = Category::all();
        $tags       = Tag::active()->ordered()->get();

        return view('admin.articles.create', compact('categories', 'tags'));
    }

    // ─────────────────────────────────────────────────────────────────
    //  STORE
    // ─────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:articles,slug',
            'content'          => 'required|string',
            'excerpt'          => 'nullable|string|max:500',
            'category_id'      => 'required|exists:categories,id',
            'status'           => 'required|in:draft,published,archived',
            'style'            => 'nullable|in:overlay,card,magazine,featured,minimal',
            'is_featured'      => 'nullable|boolean',
            'video_url'        => 'nullable|url|max:500',
            'featured_image'   => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'published_at'     => 'nullable|date',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:255',
            'tags'             => 'nullable|array',
            'tags.*'           => 'exists:tags,id',
        ]);

        // Auto slug
        if (empty($validated['slug'])) {
            $validated['slug'] = $this->uniqueSlug(Str::slug($validated['title']));
        }

        // Defaults
        $validated['admin_id']    = Auth::guard('admin')->id();
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['style']       = $validated['style'] ?? 'overlay';

        // Clear empty video_url
        if (empty($validated['video_url'])) {
            $validated['video_url'] = null;
        }

        // Auto set published_at when publishing
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Create (exclude pivot/file fields from fillable)
        $article = Article::create(
            collect($validated)->except(['tags', 'featured_image'])->toArray()
        );

        // Tags
        $article->tags()->sync($request->input('tags', []));

        // Image
        if ($request->hasFile('featured_image')) {
            $this->handleImageUpload($article, $request->file('featured_image'));
        }

        return redirect()
            ->route('admin.articles.index')
            ->with('success', "Article '{$article->title}' created successfully!");
    }

    // ─────────────────────────────────────────────────────────────────
    //  SHOW
    // ─────────────────────────────────────────────────────────────────
    public function show(Article $article)
    {
        $article->load(['category', 'admin', 'image', 'tags']);

        $wordCount   = str_word_count(strip_tags($article->content ?? ''));
        $readingTime = (int) ceil($wordCount / 200);

        $stats = [
            'views'        => $article->views_count,
            'word_count'   => $wordCount,
            'reading_time' => max(1, $readingTime),
            'status'       => $article->status,
        ];

        return view('admin.articles.show', compact('article', 'stats'));
    }

    // ─────────────────────────────────────────────────────────────────
    //  EDIT
    // ─────────────────────────────────────────────────────────────────
    public function edit(Article $article)
    {
        $categories = Category::all();
        $tags       = Tag::active()->ordered()->get();
        $article->load('tags');

        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
    }

    // ─────────────────────────────────────────────────────────────────
    //  UPDATE
    // ─────────────────────────────────────────────────────────────────
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:articles,slug,' . $article->id,
            'content'          => 'required|string',
            'excerpt'          => 'nullable|string|max:500',
            'category_id'      => 'required|exists:categories,id',
            'status'           => 'required|in:draft,published,archived',
            'style'            => 'nullable|in:overlay,card,magazine,featured,minimal',
            'is_featured'      => 'nullable|boolean',
            'video_url'        => 'nullable|url|max:500',
            'featured_image'   => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'published_at'     => 'nullable|date',
            'remove_image'     => 'nullable|boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:255',
            'tags'             => 'nullable|array',
            'tags.*'           => 'exists:tags,id',
        ]);

        // Auto slug
        if (empty($validated['slug'])) {
            $validated['slug'] = $this->uniqueSlug(Str::slug($validated['title']), $article->id);
        }

        // Booleans + style default
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['style']       = $validated['style'] ?? 'overlay';

        // Clear empty video_url
        if (empty($validated['video_url'])) {
            $validated['video_url'] = null;
        }

        // published_at transitions
        if ($validated['status'] === 'published' && ! $article->published_at) {
            $validated['published_at'] = now();
        }
        if ($validated['status'] !== 'published' && $article->status === 'published') {
            $validated['published_at'] = null;
        }

        // Remove image
        if ($request->boolean('remove_image') && $article->image) {
            $this->deleteImage($article->image);
            $validated['image_id'] = null;
        }

        // Replace image
        if ($request->hasFile('featured_image')) {
            if ($article->image) {
                $this->deleteImage($article->image);
            }
            $this->handleImageUpload($article, $request->file('featured_image'));
        }

        // Update (exclude pivot/file fields)
        $article->update(
            collect($validated)->except(['tags', 'featured_image', 'remove_image'])->toArray()
        );

        // Tags
        $article->tags()->sync($request->input('tags', []));

        return redirect()
            ->route('admin.articles.index')
            ->with('success', "Article '{$article->title}' updated successfully!");
    }

    // ─────────────────────────────────────────────────────────────────
    //  DESTROY
    // ─────────────────────────────────────────────────────────────────
    public function destroy(Article $article)
    {
        $title = $article->title;

        if ($article->image) {
            $this->deleteImage($article->image);
        }

        $article->tags()->detach();
        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', "Article '{$title}' deleted successfully!");
    }

    // ═════════════════════════════════════════════════════════════════
    //  PRIVATE HELPERS
    // ═════════════════════════════════════════════════════════════════

    /**
     * Generate a unique slug, appending -2, -3 … when duplicates exist.
     */
    private function uniqueSlug(string $base, ?int $excludeId = null): string
    {
        $slug   = $base;
        $suffix = 2;

        while (true) {
            $exists = Article::where('slug', $slug)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->exists();

            if (! $exists) break;

            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }

    /**
     * Upload a featured image, create a thumbnail, and attach the Image record.
     */
    protected function handleImageUpload(Article $article, $file): void
    {
        $uploadPath = public_path('uploads/articles');

        if (! File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $filepath = 'uploads/articles/' . $filename;
        $file->move($uploadPath, $filename);

        $fullPath  = public_path($filepath);
        $fileSize  = filesize($fullPath);
        $mimeType  = mime_content_type($fullPath);

        $thumbFilename = 'thumb_' . $filename;
        $thumbPath     = 'uploads/articles/' . $thumbFilename;
        $this->createThumbnail($fullPath, public_path($thumbPath), 400, 300);

        $image = Image::create([
            'imageable_type' => Article::class,
            'imageable_id'   => $article->id,
            'file_name'      => $filename,
            'file_path'      => $filepath,
            'file_size'      => $fileSize,
            'mime_type'      => $mimeType,
            'thumbnail_path' => $thumbPath,
        ]);

        $article->update(['image_id' => $image->id]);
    }

    /**
     * Delete image file(s) and the Image database record.
     */
    protected function deleteImage(Image $image): void
    {
        foreach ([$image->file_path, $image->thumbnail_path] as $path) {
            if ($path && File::exists(public_path($path))) {
                File::delete(public_path($path));
            }
        }

        $image->delete();
    }

    /**
     * Create a proportional thumbnail using PHP GD.
     * Falls back to a plain copy when GD is not available.
     */
    protected function createThumbnail(
        string $src,
        string $dst,
        int    $maxW = 400,
        int    $maxH = 300
    ): void {
        if (! extension_loaded('gd')) {
            copy($src, $dst);
            return;
        }

        $info = @getimagesize($src);
        if (! $info) {
            copy($src, $dst);
            return;
        }

        [$origW, $origH, $type] = $info;

        $source = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($src),
            IMAGETYPE_PNG  => imagecreatefrompng($src),
            IMAGETYPE_GIF  => imagecreatefromgif($src),
            IMAGETYPE_WEBP => imagecreatefromwebp($src),
            default        => null,
        };

        if (! $source) {
            copy($src, $dst);
            return;
        }

        // Fit inside maxW × maxH, keep aspect ratio
        $ratio = min($maxW / $origW, $maxH / $origH);
        $newW  = (int) round($origW * $ratio);
        $newH  = (int) round($origH * $ratio);

        $thumb = imagecreatetruecolor($newW, $newH);

        // Preserve transparency for PNG / GIF
        if (in_array($type, [IMAGETYPE_PNG, IMAGETYPE_GIF])) {
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
            imagefilledrectangle(
                $thumb, 0, 0, $newW, $newH,
                imagecolorallocatealpha($thumb, 255, 255, 255, 127)
            );
        }

        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newW, $newH, $origW, $origH);

        match ($type) {
            IMAGETYPE_JPEG => imagejpeg($thumb, $dst, 90),
            IMAGETYPE_PNG  => imagepng($thumb, $dst, 9),
            IMAGETYPE_GIF  => imagegif($thumb, $dst),
            IMAGETYPE_WEBP => imagewebp($thumb, $dst, 90),
            default        => copy($src, $dst),
        };

        imagedestroy($source);
        imagedestroy($thumb);
    }
}