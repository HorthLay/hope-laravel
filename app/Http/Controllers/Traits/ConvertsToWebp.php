<?php
// app/Http/Controllers/Traits/ConvertsToWebp.php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

trait ConvertsToWebp
{
    /**
     * Store any uploaded image as WebP.
     *
     * Usage:
     *   $path = $this->uploadWebp($request->file('cover'), 'articles');
     *   // returns: "uploads/articles/abc123.webp"
     *   // full URL: asset($path)
     *
     * @param  UploadedFile  $file
     * @param  string        $folder   Sub-folder inside public/uploads/
     * @param  int           $quality  WebP quality 0–100 (default 85)
     * @param  string|null   $oldPath  Previous file path to delete (relative to public/)
     * @return string                  Path relative to public/
     */
    protected function uploadWebp(
        UploadedFile $file,
        string $folder = 'uploads',
        int $quality = 85,
        ?string $oldPath = null
    ): string {
        $dir = public_path('uploads/' . trim($folder, '/'));

        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        // Delete old file if provided
        if ($oldPath && File::exists(public_path($oldPath))) {
            File::delete(public_path($oldPath));
        }

        $mime = $file->getMimeType();

        // SVG cannot be rasterized — store as-is
        if (in_array($mime, ['image/svg+xml'])) {
            $filename = uniqid() . '.svg';
            $file->move($dir, $filename);
            return 'uploads/' . trim($folder, '/') . '/' . $filename;
        }

        // Build GD image from source
        $source = match(true) {
            str_contains($mime, 'jpeg') => imagecreatefromjpeg($file->getRealPath()),
            str_contains($mime, 'png')  => $this->gdFromPng($file->getRealPath()),
            str_contains($mime, 'gif')  => imagecreatefromgif($file->getRealPath()),
            str_contains($mime, 'webp') => imagecreatefromwebp($file->getRealPath()),
            str_contains($mime, 'bmp')  => imagecreatefrombmp($file->getRealPath()),
            default => throw new \RuntimeException("Unsupported image type: {$mime}"),
        };

        $filename = uniqid() . '.webp';
        $savePath = $dir . '/' . $filename;

        imagewebp($source, $savePath, $quality);
        imagedestroy($source);

        return 'uploads/' . trim($folder, '/') . '/' . $filename;
    }

    /**
     * Same as uploadWebp() but resizes the image first.
     *
     * @param  int  $maxWidth   Max width in pixels (height auto-scales)
     */
    protected function uploadWebpResized(
        UploadedFile $file,
        string $folder = 'uploads',
        int $maxWidth = 1200,
        int $quality = 85,
        ?string $oldPath = null
    ): string {
        $dir = public_path('uploads/' . trim($folder, '/'));

        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        if ($oldPath && File::exists(public_path($oldPath))) {
            File::delete(public_path($oldPath));
        }

        $mime = $file->getMimeType();

        if (in_array($mime, ['image/svg+xml'])) {
            $filename = uniqid() . '.svg';
            $file->move($dir, $filename);
            return 'uploads/' . trim($folder, '/') . '/' . $filename;
        }

        $source = match(true) {
            str_contains($mime, 'jpeg') => imagecreatefromjpeg($file->getRealPath()),
            str_contains($mime, 'png')  => $this->gdFromPng($file->getRealPath()),
            str_contains($mime, 'gif')  => imagecreatefromgif($file->getRealPath()),
            str_contains($mime, 'webp') => imagecreatefromwebp($file->getRealPath()),
            str_contains($mime, 'bmp')  => imagecreatefrombmp($file->getRealPath()),
            default => throw new \RuntimeException("Unsupported image type: {$mime}"),
        };

        $origW = imagesx($source);
        $origH = imagesy($source);

        // Only downscale — never upscale
        if ($origW > $maxWidth) {
            $newW   = $maxWidth;
            $newH   = (int) round($origH * ($maxWidth / $origW));
            $resized = imagecreatetruecolor($newW, $newH);

            // Preserve transparency
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
            imagefilledrectangle($resized, 0, 0, $newW, $newH, $transparent);

            imagecopyresampled($resized, $source, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
            imagedestroy($source);
            $source = $resized;
        }

        $filename = uniqid() . '.webp';
        $savePath = $dir . '/' . $filename;

        imagewebp($source, $savePath, $quality);
        imagedestroy($source);

        return 'uploads/' . trim($folder, '/') . '/' . $filename;
    }

    /**
     * Handle PNG with full alpha/transparency support.
     */
    private function gdFromPng(string $path): \GdImage
    {
        $img = imagecreatefrompng($path);
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);
        return $img;
    }
}