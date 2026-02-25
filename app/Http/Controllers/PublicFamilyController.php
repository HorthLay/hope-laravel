<?php

namespace App\Http\Controllers;
use App\Models\Family;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

class PublicFamilyController extends Controller
{
      public function show(string $family): \Illuminate\View\View
    {
        try {
            $id = (int) Crypt::decryptString($family);
        } catch (DecryptException) {
            abort(404);
        }

        $family = Family::where('is_active', true)
            ->with(['members', 'sponsors'])
            ->withCount('members')
            ->findOrFail($id);

        $family->is_sponsored = $family->sponsors->isNotEmpty();
        $settingsFile = storage_path('app/settings.json');
        $settings = file_exists($settingsFile)
        ? json_decode(file_get_contents($settingsFile), true)
        : [];

        return view('sponsor.families-show', compact('family', 'settings'));
    }
}
