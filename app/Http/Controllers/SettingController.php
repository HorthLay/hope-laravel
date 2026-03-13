<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SettingController extends Controller
{
      public function index()
    {
        $settings = $this->getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name'         => 'nullable|string|max:255',
            'site_tagline'      => 'nullable|string|max:500',
            'site_description'  => 'nullable|string|max:1000',
            'contact_email'     => 'nullable|email|max:255',
            'contact_phone'     => 'nullable|string|max:50',
            'address'           => 'nullable|string|max:500',
            'whatsapp_url'      => 'nullable|string|max:255',
            'telegram_url'      => 'nullable|string|max:255',
            'instagram_url'     => 'nullable|url|max:255',
            'youtube_url'       => 'nullable|url|max:255',
            'linkedin_url'      => 'nullable|url|max:255',
            'facebook_url'      => 'nullable|url|max:255',
            'account_name'      => 'nullable|string|max:255',
            'account_bank'      => 'nullable|string|max:255',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'meta_keywords'     => 'nullable|string|max:500',
            // Accept any image type — we'll convert to WebP ourselves
            'logo'              => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg|max:4096',
            'favicon'           => 'nullable|image|mimes:ico,png,webp|max:512',
            'timezone'          => 'nullable|string|max:50',
            'date_format'       => 'nullable|string|max:50',
            'articles_per_page' => 'nullable|integer|min:1|max:100',
            'enable_comments'   => 'nullable|boolean',
            'maintenance_mode'  => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $this->handleImageUpload($request->file('logo'), 'logo');
        }

        if ($request->hasFile('favicon')) {
            // Favicon: keep as PNG if .ico, convert to WebP otherwise
            $validated['favicon'] = $this->handleImageUpload(
                $request->file('favicon'), 'favicon', 90, forceWebp: false
            );
        }

        $validated['enable_comments']  = $request->boolean('enable_comments');
        $validated['maintenance_mode'] = $request->boolean('maintenance_mode');

        $this->saveSettings($validated);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }

    /**
     * Upload an image and convert it to WebP (unless it's an SVG or ICO).
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $type        Key name used for filename (e.g. 'logo')
     * @param  int     $quality     WebP quality 0–100
     * @param  bool    $forceWebp   Set false to keep original format for favicons/SVGs
     * @return string               Path relative to public/ — e.g. "uploads/settings/logo_abc.webp"
     */
    protected function handleImageUpload($file, string $type, int $quality = 85, bool $forceWebp = true): string
    {
        $uploadPath = public_path('uploads/settings');

        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Delete old file
        $settings = $this->getSettings();
        if (!empty($settings[$type]) && File::exists(public_path($settings[$type]))) {
            File::delete(public_path($settings[$type]));
        }

        $mime = $file->getMimeType();

        // SVG and ICO can't be converted — store as-is
        $skipConvert = in_array($mime, ['image/svg+xml', 'image/x-icon', 'image/vnd.microsoft.icon'])
                    || !$forceWebp;

        if ($skipConvert) {
            $ext      = $file->getClientOriginalExtension();
            $filename = $type . '_' . time() . '.' . $ext;
            $file->move($uploadPath, $filename);
            return 'uploads/settings/' . $filename;
        }

        // ── Convert to WebP ────────────────────────────────
        $filename = $type . '_' . time() . '.webp';
        $savePath = $uploadPath . '/' . $filename;

        $source = match(true) {
            str_contains($mime, 'jpeg') => imagecreatefromjpeg($file->getRealPath()),
            str_contains($mime, 'png')  => $this->createFromPng($file->getRealPath()),
            str_contains($mime, 'gif')  => imagecreatefromgif($file->getRealPath()),
            str_contains($mime, 'webp') => imagecreatefromwebp($file->getRealPath()),
            default                     => throw new \RuntimeException("Unsupported image type: {$mime}"),
        };

        imagewebp($source, $savePath, $quality);
        imagedestroy($source);

        return 'uploads/settings/' . $filename;
    }

    /**
     * Create a true-color GD image from PNG, preserving transparency.
     */
    private function createFromPng(string $path): \GdImage
    {
        $img = imagecreatefrompng($path);
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);
        return $img;
    }

    protected function getSettings(): array
    {
        $settingsFile = storage_path('app/settings.json');

        if (File::exists($settingsFile)) {
            return json_decode(File::get($settingsFile), true) ?? [];
        }

        return [
            'site_name'         => 'Hope & Impact',
            'site_tagline'      => 'Making a Difference Together',
            'site_description'  => 'A charity organization dedicated to helping communities',
            'contact_email'     => 'contact@hopeimpact.org',
            'contact_phone'     => '',
            'address'           => '',
            'whatsapp_url'      => '',
            'telegram_url'      => '',
            'instagram_url'     => '',
            'youtube_url'       => '',
            'linkedin_url'      => '',
            'facebook_url'      => '',
            'account_name'      => 'Hope & Impact Foundation',
            'account_bank'      => 'ABA Bank · Phnom Penh, Cambodia',
            'meta_title'        => 'Hope & Impact - Charity Organization',
            'meta_description'  => 'Join us in making a difference in the world',
            'meta_keywords'     => 'charity, nonprofit, help, community',
            'logo'              => '',
            'favicon'           => '',
            'timezone'          => 'UTC',
            'date_format'       => 'M d, Y',
            'articles_per_page' => 12,
            'enable_comments'   => false,
            'maintenance_mode'  => false,
        ];
    }

    protected function saveSettings(array $newSettings): void
    {
        $settingsFile    = storage_path('app/settings.json');
        $currentSettings = $this->getSettings();
        $merged          = array_merge($currentSettings, $newSettings);
        File::put($settingsFile, json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            return redirect()
                ->route('admin.settings.index')
                ->with('success', 'Cache cleared successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }
}