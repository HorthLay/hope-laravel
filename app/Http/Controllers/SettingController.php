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
            // General Settings
            'site_name'         => 'nullable|string|max:255',
            'site_tagline'      => 'nullable|string|max:500',
            'site_description'  => 'nullable|string|max:1000',
            'contact_email'     => 'nullable|email|max:255',
            'contact_phone'     => 'nullable|string|max:50',
            'address'           => 'nullable|string|max:500',

            // Social Media (WhatsApp, Telegram, Instagram, YouTube, LinkedIn only)
            'whatsapp_url'      => 'nullable|string|max:255',
            'telegram_url'      => 'nullable|string|max:255',
            'instagram_url'     => 'nullable|url|max:255',
            'youtube_url'       => 'nullable|url|max:255',
            'linkedin_url'      => 'nullable|url|max:255',
            'facebook_url'      => 'nullable|url|max:255',

            // Sponsor / Account Details
            'account_name'      => 'nullable|string|max:255',
            'account_bank'      => 'nullable|string|max:255',

            // SEO Settings
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'meta_keywords'     => 'nullable|string|max:500',

            // Images
            'logo'              => 'nullable|image|mimes:jpeg,jpg,png,svg|max:2048',
            'favicon'           => 'nullable|image|mimes:ico,png|max:512',

            // Other Settings
            'timezone'          => 'nullable|string|max:50',
            'date_format'       => 'nullable|string|max:50',
            'articles_per_page' => 'nullable|integer|min:1|max:100',
            'enable_comments'   => 'nullable|boolean',
            'maintenance_mode'  => 'nullable|boolean',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $validated['logo'] = $this->handleImageUpload($request->file('logo'), 'logo');
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $validated['favicon'] = $this->handleImageUpload($request->file('favicon'), 'favicon');
        }

        // Checkboxes send nothing when unchecked — default to false
        $validated['enable_comments']  = $request->boolean('enable_comments');
        $validated['maintenance_mode'] = $request->boolean('maintenance_mode');

        $this->saveSettings($validated);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }

    protected function handleImageUpload($file, $type)
    {
        $uploadPath = public_path('uploads/settings');

        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Delete old file if exists
        $settings = $this->getSettings();
        if (isset($settings[$type]) && File::exists(public_path($settings[$type]))) {
            File::delete(public_path($settings[$type]));
        }

        $extension = $file->getClientOriginalExtension();
        $filename  = $type . '_' . time() . '.' . $extension;
        $file->move($uploadPath, $filename);

        return 'uploads/settings/' . $filename;
    }

    protected function getSettings()
    {
        $settingsFile = storage_path('app/settings.json');

        if (File::exists($settingsFile)) {
            return json_decode(File::get($settingsFile), true);
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

    protected function saveSettings($newSettings)
    {
        $settingsFile    = storage_path('app/settings.json');
        $currentSettings = $this->getSettings();
        $settings        = array_merge($currentSettings, $newSettings);
        File::put($settingsFile, json_encode($settings, JSON_PRETTY_PRINT));
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