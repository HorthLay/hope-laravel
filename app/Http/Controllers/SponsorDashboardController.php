<?php

namespace App\Http\Controllers;
use App\Models\ChildDocument;
use App\Models\ChildMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\FamilyDocument;
use App\Models\FamilyMedia;
class SponsorDashboardController extends Controller
{
      public function __construct()
    {
        $this->middleware('sponsor.auth');
    }

    public function index()
    {
        $sponsor = Auth::guard('sponsor')->user();

        $sponsor->load([
            'families.media',
            'families.documents',
            'families.updates',
            'families.sponsors',
            'children.updates',
            'children.media',
            'children.documents',
        ]);

        $families = $sponsor->families;
        $children = $sponsor->children;

        if ($families->isEmpty() && $children->isEmpty()) {
            return view('sponsor.no-child', compact('sponsor'));
        }

        return view('sponsor.dashboard', compact('sponsor', 'families', 'children'));
    }

    public function download($type, $id)
    {
        $sponsor = Auth::guard('sponsor')->user();

        // ── Family files ──
        if (str_starts_with($type, 'family_')) {
            $familyIds = $sponsor->families()->pluck('families.id');

            if ($type === 'family_document') {
                $file = FamilyDocument::where('id', $id)
                    ->whereIn('family_id', $familyIds)
                    ->firstOrFail();
            } elseif ($type === 'family_media') {
                $file = FamilyMedia::where('id', $id)
                    ->whereIn('family_id', $familyIds)
                    ->firstOrFail();
            } else {
                abort(404);
            }
        }

        // ── Child files ──
        elseif ($type === 'document') {
            $childIds = $sponsor->children()->pluck('sponsored_children.id');
            $file = ChildDocument::where('id', $id)
                ->whereIn('child_id', $childIds)
                ->firstOrFail();
        } elseif ($type === 'media') {
            $childIds = $sponsor->children()->pluck('sponsored_children.id');
            $file = ChildMedia::where('id', $id)
                ->whereIn('child_id', $childIds)
                ->firstOrFail();
        } else {
            abort(404);
        }

        // Files are stored in public/uploads/... not storage/app/public/
        $filePath = public_path($file->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath);
    }
}
