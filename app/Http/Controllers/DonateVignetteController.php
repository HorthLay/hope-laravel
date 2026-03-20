<?php

namespace App\Http\Controllers;

use App\Models\DonationProject;
use Illuminate\Http\Request;

class DonateVignetteController extends Controller
{
     public function show(DonationProject $donationProject)
    {
        // Must have a vignette URL set
        abort_unless(!empty($donationProject->helloasso_vignette_url), 404);
 
        // Load settings for branding
        $settings = $this->loadSettings();
        $logoPath = !empty($settings['logo']) ? asset($settings['logo']) : null;
        $siteName = $settings['site_name'] ?? 'Des Ailes pour Grandir';
 
        $lang = app()->getLocale();
 
        return view('pages.support.donate-vignette', [
            'project'     => $donationProject,
            'vignetteUrl' => $donationProject->helloasso_vignette_url,
            'title'       => $donationProject->{"title_{$lang}"}
                             ?? $donationProject->title_fr
                             ?? $donationProject->title_en,
            'description' => $donationProject->{"description_{$lang}"}
                             ?? $donationProject->description_fr
                             ?? $donationProject->description_en,
            'imgUrl'      => $donationProject->image
                             ? asset($donationProject->image)
                             : asset('images/children/image-1.jpg'),
            'siteName'    => $siteName,
            'logoUrl'     => $logoPath,
        ]);
    }
 
    private function loadSettings(): array
    {
        $file = storage_path('app/settings.json');
        return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    }
}
