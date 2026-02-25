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
        $tab = $request->get('tab', 'children'); // 'children' | 'families'

        // ── Children ─────────────────────────────────────────────────
        $childQuery = SponsoredChild::where('is_active', true)->latest();
        if ($request->filled('search')) {
            $s = $request->search;
            $childQuery->where(fn ($q) => $q
                ->where('first_name', 'like', "%$s%")
                ->orWhere('code',       'like', "%$s%")
            );
        }
        if ($request->filled('country'))  $childQuery->where('country', $request->country);

        $children = $childQuery->paginate(12, ['*'], 'cpage')->withQueryString();

        $childCountries = SponsoredChild::where('is_active', true)
            ->whereNotNull('country')->distinct()->orderBy('country')->pluck('country');

        $childStats = [
            'total'     => SponsoredChild::where('is_active', true)->count(),
            'sponsored' => SponsoredChild::where('is_active', true)->whereHas('sponsors')->count(),
            'waiting'   => SponsoredChild::where('is_active', true)->whereDoesntHave('sponsors')->count(),
            'countries' => SponsoredChild::where('is_active', true)->whereNotNull('country')->distinct('country')->count('country'),
        ];

        // ── Families ──────────────────────────────────────────────────
        $familyQuery = Family::withCount('members')->where('is_active', true)->latest();
        if ($request->filled('search')) {
            $s = $request->search;
            $familyQuery->where(fn ($q) => $q
                ->where('name',    'like', "%$s%")
                ->orWhere('code',  'like', "%$s%")
                ->orWhere('story', 'like', "%$s%")
            );
        }
        if ($request->filled('country')) $familyQuery->where('country', $request->country);

        $families = $familyQuery->paginate(12, ['*'], 'fpage')->withQueryString();

        $familyCountries = Family::where('is_active', true)
            ->whereNotNull('country')->distinct()->orderBy('country')->pluck('country');

        $familyStats = [
            'total'     => Family::where('is_active', true)->count(),
            'sponsored' => Family::where('is_active', true)->whereHas('sponsors')->count(),
            'waiting'   => Family::where('is_active', true)->whereDoesntHave('sponsors')->count(),
            'members'   => \App\Models\FamilyMember::where('is_active', true)->count(),
        ];

        $settingsFile = storage_path('app/settings.json');
        $settings = file_exists($settingsFile)
        ? json_decode(file_get_contents($settingsFile), true)
        : [];

        return view('sponsor.index', compact(
            'tab',
            'children', 'childCountries', 'childStats','settings',
            'families', 'familyCountries', 'familyStats'
        ));
    }

    // ──────────────────────────────────────────────────────────────────
    //  SPONSOR A CHILD FORM  →  route('sponsor.child')
    // ──────────────────────────────────────────────────────────────────
    public function sponsorChild(string $encId)
    {
        $child = SponsoredChild::where('is_active', true)
            ->findOrFail($this->decryptId($encId));

        return view('sponsor.child-form', compact('child'));
    }

    // ──────────────────────────────────────────────────────────────────
    //  SPONSOR A FAMILY FORM  →  route('sponsor.family')
    // ──────────────────────────────────────────────────────────────────
    public function sponsorFamily(string $encId)
    {
        $family = Family::where('is_active', true)
            ->with(['members', 'children' => fn ($q) => $q->where('is_active', true)])
            ->withCount('members')
            ->findOrFail($this->decryptId($encId));

        return view('sponsor.family-form', compact('family'));
    }

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
