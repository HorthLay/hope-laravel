<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use App\Models\SponsoredChild;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChildrenController extends Controller
{
        /* ─────────────────────────────────────────
     | GET /admin/children
     ───────────────────────────────────────── */
    public function index(Request $request)
    {
        $query = SponsoredChild::with('sponsors')->latest(); // sponsors (plural)

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('code', 'like', "%$search%")
                  ->orWhere('country', 'like', "%$search%");
            });
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($country = $request->get('country')) {
            $query->where('country', $country);
        }

        $children = $query->paginate(12)->withQueryString();

        $stats = [
            'total'     => SponsoredChild::count(),
            'active'    => SponsoredChild::where('is_active', true)->count(),
            'inactive'  => SponsoredChild::where('is_active', false)->count(),
            'sponsored' => SponsoredChild::has('sponsors')->count(), // sponsors (plural)
        ];

        $countries = SponsoredChild::distinct()->orderBy('country')->pluck('country')->filter();

        return view('admin.children.index', compact('children', 'stats', 'countries'));
    }

    /* ─────────────────────────────────────────
     | GET /admin/children/create
     ───────────────────────────────────────── */
    public function create()
    {
        return view('admin.children.create');
    }

    /* ─────────────────────────────────────────
     | POST /admin/children
     ───────────────────────────────────────── */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:255',
            'code'          => 'nullable|string|max:50|unique:sponsored_children,code',
            'birth_year'    => 'nullable|integer|min:1990|max:' . now()->year,
            'country'       => 'nullable|string|max:100',
            'story'         => 'nullable|string',
            'is_active'     => 'boolean',
            'profile_photo' => 'nullable|image|max:2048',
            'has_family'    => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        if (empty($data['code'])) {
            $data['code'] = 'CH-' . strtoupper(Str::random(6));
        }

        unset($data['profile_photo']);
        $child = SponsoredChild::create($data);

        if ($request->hasFile('profile_photo')) {
            $this->handleImageUpload($child, $request->file('profile_photo'));
        }

        return redirect()->route('admin.children.index')
            ->with('success', "\"{$child->first_name}\" has been added successfully.");
    }

    /* ─────────────────────────────────────────
     | GET /admin/children/{child}
     ───────────────────────────────────────── */
    public function show(SponsoredChild $child)
    {
        $child->load(['sponsors', 'updates', 'media', 'documents', 'articles']);
        return view('admin.children.show', compact('child'));
    }

    /* ─────────────────────────────────────────
     | GET /admin/children/{child}/edit
     ───────────────────────────────────────── */
    public function edit(SponsoredChild $child)
    {
        $child->load('sponsors'); // load sponsors for display in edit view if needed
        return view('admin.children.edit', compact('child'));
    }

    /* ─────────────────────────────────────────
     | PUT /admin/children/{child}
     ───────────────────────────────────────── */
    public function update(Request $request, SponsoredChild $child)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:255',
            'code'          => 'nullable|string|max:50|unique:sponsored_children,code,' . $child->id,
            'birth_year'    => 'nullable|integer|min:1990|max:' . now()->year,
            'country'       => 'nullable|string|max:100',
            'story'         => 'nullable|string',
            'is_active'     => 'boolean',
            'profile_photo' => 'nullable|image|max:2048',
            'has_family'    => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        unset($data['profile_photo']);
        $child->update($data);

        if ($request->hasFile('profile_photo')) {
            $this->deletePhoto($child);
            $this->handleImageUpload($child, $request->file('profile_photo'));
        }

        if ($request->boolean('remove_photo')) {
            $this->deletePhoto($child);
            $child->update(['profile_photo' => null]);
        }

        return redirect()->route('admin.children.show', $child)
            ->with('success', "\"{$child->first_name}\" has been updated successfully.");
    }

    /* ─────────────────────────────────────────
     | DELETE /admin/children/{child}
     ───────────────────────────────────────── */
    public function destroy(SponsoredChild $child)
    {
        $name = $child->first_name;
        $this->deletePhoto($child);
        $child->sponsors()->detach();   // detach pivot records before delete
        $child->articles()->detach();   // detach article pivot records too
        $child->delete();

        return redirect()->route('admin.children.index')
            ->with('success', "\"{$name}\" has been deleted.");
    }

    /* ═════════════════════════════════════════
     | Image Helpers
     ═════════════════════════════════════════ */
    protected function handleImageUpload(SponsoredChild $child, $file): void
    {
        $uploadPath = public_path('uploads/children');

        if (! File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $filepath = 'uploads/children/' . $filename;
        $file->move($uploadPath, $filename);

        $fullPath      = public_path($filepath);
        $thumbFilename = 'thumb_' . $filename;
        $thumbPath     = 'uploads/children/' . $thumbFilename;
        $this->createThumbnail($fullPath, public_path($thumbPath), 400, 400);

        $child->update(['profile_photo' => $filepath]);
    }

    protected function deletePhoto(SponsoredChild $child): void
    {
        if (! $child->profile_photo) return;

        $fullPath  = public_path($child->profile_photo);
        $thumbPath = public_path(
            dirname($child->profile_photo) . '/thumb_' . basename($child->profile_photo)
        );

        if (file_exists($fullPath))  @unlink($fullPath);
        if (file_exists($thumbPath)) @unlink($thumbPath);
    }

    protected function createThumbnail(
        string $sourcePath,
        string $destPath,
        int    $thumbWidth  = 400,
        int    $thumbHeight = 400
    ): void {
        if (! file_exists($sourcePath)) return;

        $mime = mime_content_type($sourcePath);

        $src = match ($mime) {
            'image/jpeg', 'image/jpg' => imagecreatefromjpeg($sourcePath),
            'image/png'               => imagecreatefrompng($sourcePath),
            'image/gif'               => imagecreatefromgif($sourcePath),
            'image/webp'              => imagecreatefromwebp($sourcePath),
            default                   => null,
        };

        if (! $src) return;

        [$origW, $origH] = getimagesize($sourcePath);

        $ratio = min($thumbWidth / $origW, $thumbHeight / $origH);
        $newW  = (int) round($origW * $ratio);
        $newH  = (int) round($origH * $ratio);

        $thumb = imagecreatetruecolor($newW, $newH);

        if (in_array($mime, ['image/png', 'image/gif'])) {
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
            $transparent = imagecolorallocatealpha($thumb, 0, 0, 0, 127);
            imagefilledrectangle($thumb, 0, 0, $newW, $newH, $transparent);
        }

        imagecopyresampled($thumb, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);

        match ($mime) {
            'image/png'  => imagepng($thumb,  $destPath, 8),
            'image/gif'  => imagegif($thumb,  $destPath),
            'image/webp' => imagewebp($thumb, $destPath, 85),
            default      => imagejpeg($thumb, $destPath, 85),
        };

        imagedestroy($src);
        imagedestroy($thumb);
    }
}
