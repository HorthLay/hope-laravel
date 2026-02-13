<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MediaController extends Controller
{
     public function index(Request $request)
    {
        $query = Image::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('file_name', 'like', "%{$search}%")
                  ->orWhere('alt_text', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $type = $request->type;
            $query->where('mime_type', 'like', "{$type}%");
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Get images with pagination
        $images = $query->paginate(24)->withQueryString();

        // Calculate stats
        $stats = [
            'total_images' => Image::count(),
            'total_size' => Image::sum('file_size'),
            'images_this_month' => Image::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        return view('admin.media.index', compact('images', 'stats'));
    }

    /**
     * Store a newly uploaded image
     */
    public function store(Request $request)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:5120', // 5MB
        ]);

        $uploadedImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $image = $this->handleImageUpload($file);
                $uploadedImages[] = $image;
            }
        }

        return redirect()
            ->route('admin.media.index')
            ->with('success', count($uploadedImages) . ' image(s) uploaded successfully!');
    }

    /**
     * Update the specified image
     */
    public function update(Request $request, Image $image)
    {
        $validated = $request->validate([
            'alt_text' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
        ]);

        $image->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Image updated successfully!'
        ]);
    }

    /**
     * Remove the specified image
     */
    public function destroy(Image $image)
    {
        // Delete files
        if (File::exists(public_path($image->file_path))) {
            File::delete(public_path($image->file_path));
        }

        if ($image->thumbnail_path && File::exists(public_path($image->thumbnail_path))) {
            File::delete(public_path($image->thumbnail_path));
        }

        // Delete database record
        $image->delete();

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Image deleted successfully!');
    }

    /**
     * Handle image upload
     */
    protected function handleImageUpload($file)
    {
        // Create upload directory if it doesn't exist
        $uploadPath = public_path('uploads/media');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Generate unique filename
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $filepath = 'uploads/media/' . $filename;

        // Move original file
        $file->move($uploadPath, $filename);

        // Get file info
        $fullPath = public_path($filepath);
        $fileSize = filesize($fullPath);
        $mimeType = mime_content_type($fullPath);

        // Get image dimensions if it's an image
        $width = null;
        $height = null;
        if (strpos($mimeType, 'image') !== false) {
            $imageInfo = getimagesize($fullPath);
            if ($imageInfo) {
                $width = $imageInfo[0];
                $height = $imageInfo[1];
            }
        }

        // Create thumbnail (if image)
        $thumbnailPath = null;
        if (strpos($mimeType, 'image') !== false) {
            $thumbnailFilename = 'thumb_' . $filename;
            $thumbnailPath = 'uploads/media/' . $thumbnailFilename;
            
            // Create thumbnail
            $this->createThumbnail($fullPath, public_path($thumbnailPath), 300, 300);
        }

        // Create image record
        $image = Image::create([
            'file_name' => $filename,
            'file_path' => $filepath,
            'thumbnail_path' => $thumbnailPath,
            'file_size' => $fileSize,
            'mime_type' => $mimeType,
            'width' => $width,
            'height' => $height,
        ]);

        return $image;
    }

    /**
     * Create thumbnail using PHP GD
     */
    protected function createThumbnail($sourcePath, $destinationPath, $width, $height)
    {
        // Check if GD is available
        if (!extension_loaded('gd')) {
            copy($sourcePath, $destinationPath);
            return;
        }

        // Get image info
        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            copy($sourcePath, $destinationPath);
            return;
        }

        list($origWidth, $origHeight, $imageType) = $imageInfo;

        // Create image resource based on type
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
                $sourceImage = imagecreatefromgif($sourcePath);
                break;
            case IMAGETYPE_WEBP:
                $sourceImage = imagecreatefromwebp($sourcePath);
                break;
            default:
                copy($sourcePath, $destinationPath);
                return;
        }

        if (!$sourceImage) {
            copy($sourcePath, $destinationPath);
            return;
        }

        // Calculate dimensions to maintain aspect ratio
        $sourceAspect = $origWidth / $origHeight;
        $thumbAspect = $width / $height;

        if ($sourceAspect > $thumbAspect) {
            $newWidth = $width;
            $newHeight = $width / $sourceAspect;
        } else {
            $newHeight = $height;
            $newWidth = $height * $sourceAspect;
        }

        // Create thumbnail
        $thumbnail = imagecreatetruecolor($width, $height);

        // Preserve transparency for PNG and GIF
        if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
            imagealphablending($thumbnail, false);
            imagesavealpha($thumbnail, true);
            $transparent = imagecolorallocatealpha($thumbnail, 255, 255, 255, 127);
            imagefilledrectangle($thumbnail, 0, 0, $width, $height, $transparent);
        }

        // Calculate centering
        $offsetX = ($width - $newWidth) / 2;
        $offsetY = ($height - $newHeight) / 2;

        // Resize and copy
        imagecopyresampled(
            $thumbnail, 
            $sourceImage, 
            $offsetX, 
            $offsetY, 
            0, 
            0, 
            $newWidth, 
            $newHeight, 
            $origWidth, 
            $origHeight
        );

        // Save thumbnail based on original type
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                imagejpeg($thumbnail, $destinationPath, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($thumbnail, $destinationPath, 9);
                break;
            case IMAGETYPE_GIF:
                imagegif($thumbnail, $destinationPath);
                break;
            case IMAGETYPE_WEBP:
                imagewebp($thumbnail, $destinationPath, 90);
                break;
        }

        // Free memory
        imagedestroy($sourceImage);
        imagedestroy($thumbnail);
    }
}
