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

    public function sponsorship()
    {
        $sponsor = Auth::guard('sponsor')->user();

        $sponsor->load([
            'children.media',
            'children.documents',
            'children.updates',
            'families.media',
            'families.documents',
            'families.updates',
            'families.members',
        ]);

        return view('sponsor.sponsorship', compact('sponsor'));
    }

    public function news()
    {
        $sponsor = Auth::guard('sponsor')->user();
        $articles = \App\Models\Article::with(['category', 'image', 'tags'])
            ->published()
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $articles->getCollection()->transform(function ($article) {
            $article->encrypted_id   = \Illuminate\Support\Facades\Crypt::encryptString((string) $article->id);
            $article->encrypted_slug = \Illuminate\Support\Facades\Crypt::encryptString($article->slug);
            return $article;
        });

        return view('sponsor.news', compact('sponsor', 'articles'));
    }
}
