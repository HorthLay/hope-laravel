<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use App\Models\Category;
use App\Models\Family;
use App\Models\SponsoredChild;
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
        $children   = SponsoredChild::where('is_active', true)
                        ->orderBy('first_name')
                        ->get(['id', 'first_name', 'code', 'profile_photo']);
        $families   = Family::where('is_active', true)
                        ->orderBy('name')
                        ->get(['id', 'name', 'code', 'profile_photo']);

        return view('admin.articles.create', compact('categories', 'tags', 'children', 'families'));
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
            'children'         => 'nullable|array',
            'children.*'       => 'exists:sponsored_children,id',
            'families'         => 'nullable|array',
            'families.*'       => 'exists:families,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = $this->uniqueSlug(Str::slug($validated['title']));
        }

        $validated['admin_id']    = Auth::guard('admin')->id();
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['style']       = $validated['style'] ?? 'overlay';

        if (empty($validated['video_url'])) {
            $validated['video_url'] = null;
        }

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $article = Article::create(
            collect($validated)->except(['tags', 'featured_image', 'children', 'families'])->toArray()
        );

        $article->tags()->sync($request->input('tags', []));
        $article->sponsoredChildren()->sync($request->input('children', []));
        $article->families()->sync($request->input('families', []));

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
        $article->load(['category', 'admin', 'image', 'tags', 'sponsoredChildren', 'families']);

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
        $children   = SponsoredChild::where('is_active', true)
                        ->orderBy('first_name')
                        ->get(['id', 'first_name', 'code', 'profile_photo']);
        $families   = Family::where('is_active', true)
                        ->orderBy('name')
                        ->get(['id', 'name', 'code', 'profile_photo']);

        $article->load('tags', 'sponsoredChildren', 'families');

        return view('admin.articles.edit', compact('article', 'categories', 'tags', 'children', 'families'));
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
            'children'         => 'nullable|array',
            'children.*'       => 'exists:sponsored_children,id',
            'families'         => 'nullable|array',
            'families.*'       => 'exists:families,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = $this->uniqueSlug(Str::slug($validated['title']), $article->id);
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['style']       = $validated['style'] ?? 'overlay';

        if (empty($validated['video_url'])) {
            $validated['video_url'] = null;
        }

        if ($validated['status'] === 'published' && ! $article->published_at) {
            $validated['published_at'] = now();
        }
        if ($validated['status'] !== 'published' && $article->status === 'published') {
            $validated['published_at'] = null;
        }

        if ($request->boolean('remove_image') && $article->image) {
            $this->deleteImage($article->image);
            $validated['image_id'] = null;
        }

        if ($request->hasFile('featured_image')) {
            if ($article->image) $this->deleteImage($article->image);
            $this->handleImageUpload($article, $request->file('featured_image'));
        }

        $article->update(
            collect($validated)->except(['tags', 'featured_image', 'remove_image', 'children', 'families'])->toArray()
        );

        $article->tags()->sync($request->input('tags', []));
        $article->sponsoredChildren()->sync($request->input('children', []));
        $article->families()->sync($request->input('families', []));

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

        if ($article->image) $this->deleteImage($article->image);

        $article->tags()->detach();
        $article->sponsoredChildren()->detach();
        $article->families()->detach();
        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', "Article '{$title}' deleted successfully!");
    }

    // ═════════════════════════════════════════════════════════════════
    //  PRIVATE HELPERS
    // ═════════════════════════════════════════════════════════════════
    private function uniqueSlug(string $base, ?int $excludeId = null): string
    {
        $slug = $base; $suffix = 2;
        while (true) {
            $exists = Article::where('slug', $slug)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->exists();
            if (! $exists) break;
            $slug = "{$base}-{$suffix}"; $suffix++;
        }
        return $slug;
    }

    protected function handleImageUpload(Article $article, $file): void
    {
        $uploadPath = public_path('uploads/articles');
        if (! File::exists($uploadPath)) File::makeDirectory($uploadPath, 0755, true);

        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $filepath = 'uploads/articles/' . $filename;
        $file->move($uploadPath, $filename);

        $fullPath      = public_path($filepath);
        $thumbFilename = 'thumb_' . $filename;
        $thumbPath     = 'uploads/articles/' . $thumbFilename;
        $this->createThumbnail($fullPath, public_path($thumbPath), 400, 300);

        $image = Image::create([
            'imageable_type' => Article::class,
            'imageable_id'   => $article->id,
            'file_name'      => $filename,
            'file_path'      => $filepath,
            'file_size'      => filesize($fullPath),
            'mime_type'      => mime_content_type($fullPath),
            'thumbnail_path' => $thumbPath,
        ]);

        $article->update(['image_id' => $image->id]);
    }

    protected function deleteImage(Image $image): void
    {
        foreach ([$image->file_path, $image->thumbnail_path] as $path) {
            if ($path && File::exists(public_path($path))) File::delete(public_path($path));
        }
        $image->delete();
    }

    protected function createThumbnail(string $src, string $dst, int $maxW = 400, int $maxH = 300): void
    {
        if (! extension_loaded('gd')) { copy($src, $dst); return; }
        $info = @getimagesize($src);
        if (! $info) { copy($src, $dst); return; }
        [$origW, $origH, $type] = $info;
        $source = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($src),
            IMAGETYPE_PNG  => imagecreatefrompng($src),
            IMAGETYPE_GIF  => imagecreatefromgif($src),
            IMAGETYPE_WEBP => imagecreatefromwebp($src),
            default        => null,
        };
        if (! $source) { copy($src, $dst); return; }
        $ratio = min($maxW / $origW, $maxH / $origH);
        $newW  = (int) round($origW * $ratio);
        $newH  = (int) round($origH * $ratio);
        $thumb = imagecreatetruecolor($newW, $newH);
        if (in_array($type, [IMAGETYPE_PNG, IMAGETYPE_GIF])) {
            imagealphablending($thumb, false); imagesavealpha($thumb, true);
            imagefilledrectangle($thumb, 0, 0, $newW, $newH, imagecolorallocatealpha($thumb, 255, 255, 255, 127));
        }
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
        match ($type) {
            IMAGETYPE_JPEG => imagejpeg($thumb, $dst, 90),
            IMAGETYPE_PNG  => imagepng($thumb, $dst, 9),
            IMAGETYPE_GIF  => imagegif($thumb, $dst),
            IMAGETYPE_WEBP => imagewebp($thumb, $dst, 90),
            default        => copy($src, $dst),
        };
        imagedestroy($source); imagedestroy($thumb);
    }
}