<?php

namespace App\Http\Controllers;
use App\Models\SponsoredChild;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PublicChildController extends Controller
{
     public function show(string $child): \Illuminate\View\View
    {
        try {
            $id = (int) Crypt::decryptString($child);
        } catch (DecryptException) {
            abort(404);
        }

        $child = SponsoredChild::query()
            ->where('is_active', true)
            ->with(['sponsors'])
            ->findOrFail($id);
        
        $settingsFile = storage_path('app/settings.json');
        $settings = file_exists($settingsFile)
        ? json_decode(file_get_contents($settingsFile), true)
        : [];

        $child->is_sponsored = $child->sponsors->isNotEmpty();

        return view('sponsor.children-show', compact('child', 'settings'));
    }
}
