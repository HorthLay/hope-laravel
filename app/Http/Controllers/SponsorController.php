<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\SponsoredChild;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class SponsorController extends Controller
{
    // ──────────────────────────────────────────────────────────────────
    //  TABBED INDEX — Children + Families on one page
    //  Route: GET /sponsor   name: sponsor.children
    // ──────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $settingsFile = storage_path('app/settings.json');
        $settings = file_exists($settingsFile)
        ? json_decode(file_get_contents($settingsFile), true)
        : [];

        return view('sponsor.index', compact('settings'));
    }

    // ──────────────────────────────────────────────────────────────────
    //  SPONSOR A CHILD FORM  →  route('sponsor.child')
    // ──────────────────────────────────────────────────────────────────
    // public function sponsorChild(string $encId)
    // {
    //     $child = SponsoredChild::where('is_active', true)
    //         ->findOrFail($this->decryptId($encId));

    //     return view('sponsor.child-form', compact('child'));
    // }

    // ──────────────────────────────────────────────────────────────────
    //  SPONSOR A FAMILY FORM  →  route('sponsor.family')
    // ──────────────────────────────────────────────────────────────────
    // public function sponsorFamily(string $encId)
    // {
    //     $family = Family::where('is_active', true)
    //         ->with(['members', 'children' => fn ($q) => $q->where('is_active', true)])
    //         ->withCount('members')
    //         ->findOrFail($this->decryptId($encId));

    //     return view('sponsor.family-form', compact('family'));
    // }

    // ──────────────────────────────────────────────────────────────────
    //  HELPER
    // ──────────────────────────────────────────────────────────────────
    private function decryptId(string $encId): int
    {
        try {
            return (int) Crypt::decryptString($encId);
        } catch (DecryptException) {
            abort(404);
        }
    }
}
