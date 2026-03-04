<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Article;
use App\Models\Category;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\SiteVisit;
use App\Models\Sponsor;
use App\Models\SponsoredChild;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
 
         public function index(Request $request)
    {
        $range     = $request->get('range', 30);
        $startDate = now()->subDays($range);

        // ── Overview stats ────────────────────────────────────────
        $totalViews        = Article::sum('views_count');
        $publishedArticles = Article::where('status', 'published')->count();
        $draftArticles     = Article::where('status', 'draft')->count();
        $totalVisits       = SiteVisit::count();
        $totalCategories   = Category::count();
        $totalAdmins       = Admin::count();
        $newArticles       = Article::where('created_at', '>=', $startDate)->count();

        // ── Growth vs previous period ─────────────────────────────
        $prevStart = now()->subDays($range * 2);

        $currentVisits  = SiteVisit::where('created_at', '>=', $startDate)->count();
        $previousVisits = SiteVisit::whereBetween('created_at', [$prevStart, $startDate])->count();
        $visitsGrowth   = $previousVisits > 0
            ? round((($currentVisits - $previousVisits) / $previousVisits) * 100, 1)
            : ($currentVisits > 0 ? 100 : 0);

        $currentArticles  = Article::where('created_at', '>=', $startDate)->count();
        $previousArticles = Article::whereBetween('created_at', [$prevStart, $startDate])->count();
        $articlesGrowth   = $previousArticles > 0
            ? round((($currentArticles - $previousArticles) / $previousArticles) * 100, 1)
            : ($currentArticles > 0 ? 100 : 0);

        // ── Top articles ──────────────────────────────────────────
        $topArticles = Article::with(['category', 'image'])
            ->orderBy('views_count', 'desc')
            ->limit(10)
            ->get();

        // ── Articles by status ────────────────────────────────────
        $articlesByStatus = Article::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // ── Top categories ────────────────────────────────────────
        $topCategories = Category::withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->limit(8)
            ->get();

        // ── Traffic by device ─────────────────────────────────────
        $rawDevice   = SiteVisit::select('device_type', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('device_type')
            ->get()
            ->pluck('count', 'device_type')
            ->toArray();
        $deviceStats  = array_merge(['desktop' => 0, 'mobile' => 0, 'tablet' => 0], $rawDevice);
        $totalDevices = max(array_sum($deviceStats), 1);

        // ── Traffic by browser ────────────────────────────────────
        $browserStats  = SiteVisit::select('browser', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();
        $totalBrowsers = max($browserStats->sum('count'), 1);

        // ── Top countries ─────────────────────────────────────────
        $topCountries  = SiteVisit::select('country', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('country')
            ->where('country', '!=', '')
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->limit(8)
            ->get();
        $totalCountries = max($topCountries->sum('count'), 1);

        // ── Top authors ───────────────────────────────────────────
        $topAuthors = Admin::withCount('articles')
            ->having('articles_count', '>', 0)
            ->orderBy('articles_count', 'desc')
            ->limit(5)
            ->get();

        // ════════════════════════════════════════════════════════
        // CHILDREN STATISTICS
        // ════════════════════════════════════════════════════════
        $totalChildren       = SponsoredChild::count();
        $activeChildren      = SponsoredChild::where('is_active', true)->count();
        $sponsoredChildren   = SponsoredChild::where('is_active', true)->whereHas('sponsors')->count();
        $unsponsoredChildren = SponsoredChild::where('is_active', true)->whereDoesntHave('sponsors')->count();
        $childrenCountries   = SponsoredChild::where('is_active', true)
                                    ->whereNotNull('country')->distinct('country')->count('country');
        $newChildrenPeriod   = SponsoredChild::where('created_at', '>=', $startDate)->count();
        $childPct            = $activeChildren > 0
                                    ? round($sponsoredChildren / $activeChildren * 100)
                                    : 0;

        // Country breakdown (top 6)
        $childrenByCountry = SponsoredChild::where('is_active', true)
            ->whereNotNull('country')
            ->select('country', DB::raw('count(*) as count'))
            ->groupBy('country')
            ->orderByDesc('count')
            ->limit(6)
            ->get();

        // Sponsored vs unsponsored trend (new children per period week)
        $childrenTrend = SponsoredChild::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // ════════════════════════════════════════════════════════
        // FAMILY STATISTICS
        // ════════════════════════════════════════════════════════
        $totalFamilies       = Family::count();
        $activeFamilies      = Family::where('is_active', true)->count();
        $sponsoredFamilies   = Family::where('is_active', true)->whereHas('sponsors')->count();
        $unsponsoredFamilies = Family::where('is_active', true)->whereDoesntHave('sponsors')->count();
        $totalFamilyMembers  = FamilyMember::count();
        $newFamiliesPeriod   = Family::where('created_at', '>=', $startDate)->count();
        $familyPct           = $activeFamilies > 0
                                    ? round($sponsoredFamilies / $activeFamilies * 100)
                                    : 0;
        $avgMembersPerFamily = $activeFamilies > 0
                                    ? round($totalFamilyMembers / $activeFamilies, 1)
                                    : 0;

        // Family country breakdown (top 6)
        $familiesByCountry = Family::where('is_active', true)
            ->whereNotNull('country')
            ->select('country', DB::raw('count(*) as count'))
            ->groupBy('country')
            ->orderByDesc('count')
            ->limit(6)
            ->get();

        // ════════════════════════════════════════════════════════
        // SPONSOR STATISTICS
        // ════════════════════════════════════════════════════════
        $totalSponsors       = Sponsor::count();
        $activeSponsors      = Sponsor::where('is_active', true)->count();
        $inactiveSponsors    = Sponsor::where('is_active', false)->count();
        $newSponsorsPeriod   = Sponsor::where('created_at', '>=', $startDate)->count();
        $prevSponsors        = Sponsor::whereBetween('created_at', [$prevStart, $startDate])->count();
        $sponsorsGrowth      = $prevSponsors > 0
                                    ? round((($newSponsorsPeriod - $prevSponsors) / $prevSponsors) * 100, 1)
                                    : ($newSponsorsPeriod > 0 ? 100 : 0);

        // Sponsors who sponsor children, families, or both
        $sponsorsWithChildren  = Sponsor::whereHas('children')->count();
        $sponsorsWithFamilies  = Sponsor::whereHas('families')->count();
        $sponsorsWithBoth      = Sponsor::whereHas('children')->whereHas('families')->count();
        $sponsorsWithAny       = Sponsor::where(fn($q) => $q->whereHas('children')->orWhereHas('families'))->count();

        // Recently joined sponsors
        $recentSponsors = Sponsor::latest()->take(6)->get();

        // Most active sponsors (most sponsorships)
        $topSponsors = Sponsor::withCount(['children', 'families'])
            ->having('children_count', '>', 0)
            ->orHaving('families_count', '>', 0)
            ->orderByRaw('children_count + families_count DESC')
            ->limit(6)
            ->get();

        // ── Combined sponsorship summary ──────────────────────────
        $totalBeneficiaries  = $activeChildren + $totalFamilyMembers;
        $totalSponsored      = $sponsoredChildren + $sponsoredFamilies;
        $totalUnsponsored    = $unsponsoredChildren + $unsponsoredFamilies;

        return view('admin.reports.index', compact(
            'range',
            // Article / site
            'totalViews', 'publishedArticles', 'draftArticles',
            'totalVisits', 'totalCategories', 'totalAdmins', 'newArticles',
            'visitsGrowth', 'articlesGrowth',
            'topArticles', 'articlesByStatus', 'topCategories',
            'deviceStats', 'totalDevices',
            'browserStats', 'totalBrowsers',
            'topCountries', 'totalCountries',
            'topAuthors',
            // Children
            'totalChildren', 'activeChildren', 'sponsoredChildren',
            'unsponsoredChildren', 'childrenCountries',
            'newChildrenPeriod', 'childPct',
            'childrenByCountry', 'childrenTrend',
            // Families
            'totalFamilies', 'activeFamilies', 'sponsoredFamilies',
            'unsponsoredFamilies', 'totalFamilyMembers',
            'newFamiliesPeriod', 'familyPct', 'avgMembersPerFamily',
            'familiesByCountry',
            // Sponsors
            'totalSponsors', 'activeSponsors', 'inactiveSponsors',
            'newSponsorsPeriod', 'sponsorsGrowth',
            'sponsorsWithChildren', 'sponsorsWithFamilies',
            'sponsorsWithBoth', 'sponsorsWithAny',
            'recentSponsors', 'topSponsors',
            // Combined
            'totalBeneficiaries', 'totalSponsored', 'totalUnsponsored'
        ));
    }

    public function export(Request $request)
    {
        $range     = $request->get('range', 30);
        $startDate = now()->subDays($range);

        $rows   = [];
        $rows[] = ['Hope & Impact - Report Export'];
        $rows[] = ['Generated', now()->format('Y-m-d H:i:s')];
        $rows[] = ['Period', "Last {$range} days"];
        $rows[] = [];

        $rows[] = ['=== OVERVIEW ==='];
        $rows[] = ['Metric', 'Value'];
        $rows[] = ['Total Articles', Article::count()];
        $rows[] = ['Published Articles', Article::where('status', 'published')->count()];
        $rows[] = ['Draft Articles', Article::where('status', 'draft')->count()];
        $rows[] = ['Total Views', Article::sum('views_count')];
        $rows[] = ['Total Site Visits', SiteVisit::count()];
        $rows[] = ['Total Categories', Category::count()];
        $rows[] = ['New Articles This Period', Article::where('created_at', '>=', $startDate)->count()];
        $rows[] = [];

        $rows[] = ['=== CHILDREN SPONSORSHIP ==='];
        $rows[] = ['Metric', 'Value'];
        $rows[] = ['Total Children',       SponsoredChild::count()];
        $rows[] = ['Active Children',      SponsoredChild::where('is_active', true)->count()];
        $rows[] = ['Sponsored Children',   SponsoredChild::where('is_active', true)->whereHas('sponsors')->count()];
        $rows[] = ['Unsponsored Children', SponsoredChild::where('is_active', true)->whereDoesntHave('sponsors')->count()];
        $rows[] = ['New This Period',      SponsoredChild::where('created_at', '>=', $startDate)->count()];
        $rows[] = [];

        $rows[] = ['=== FAMILY SPONSORSHIP ==='];
        $rows[] = ['Metric', 'Value'];
        $rows[] = ['Total Families',       Family::count()];
        $rows[] = ['Active Families',      Family::where('is_active', true)->count()];
        $rows[] = ['Sponsored Families',   Family::where('is_active', true)->whereHas('sponsors')->count()];
        $rows[] = ['Unsponsored Families', Family::where('is_active', true)->whereDoesntHave('sponsors')->count()];
        $rows[] = ['Total Family Members', FamilyMember::count()];
        $rows[] = ['New This Period',      Family::where('created_at', '>=', $startDate)->count()];
        $rows[] = [];

        $rows[] = ['=== SPONSOR STATISTICS ==='];
        $rows[] = ['Metric', 'Value'];
        $rows[] = ['Total Sponsors',           Sponsor::count()];
        $rows[] = ['Active Sponsors',           Sponsor::where('is_active', true)->count()];
        $rows[] = ['New This Period',           Sponsor::where('created_at', '>=', $startDate)->count()];
        $rows[] = ['Sponsoring Children',       Sponsor::whereHas('children')->count()];
        $rows[] = ['Sponsoring Families',       Sponsor::whereHas('families')->count()];
        $rows[] = ['Sponsoring Both',           Sponsor::whereHas('children')->whereHas('families')->count()];
        $rows[] = [];

        $rows[] = ['=== TOP SPONSORS ==='];
        $rows[] = ['Name', 'Email', 'Children Sponsored', 'Families Sponsored', 'Active'];
        Sponsor::withCount(['children', 'families'])
            ->having('children_count', '>', 0)->orHaving('families_count', '>', 0)
            ->orderByRaw('children_count + families_count DESC')->limit(20)->get()
            ->each(fn($s) => $rows[] = [
                $s->full_name, $s->email,
                $s->children_count, $s->families_count,
                $s->is_active ? 'Yes' : 'No',
            ]);
        $rows[] = [];

        $rows[] = ['=== TOP ARTICLES BY VIEWS ==='];
        $rows[] = ['Title', 'Category', 'Views', 'Status', 'Published Date'];
        Article::with('category')->orderBy('views_count', 'desc')->limit(20)->get()
            ->each(function ($a) use (&$rows) {
                $rows[] = [
                    $a->title,
                    $a->category->name ?? 'Uncategorized',
                    $a->views_count,
                    $a->status,
                    $a->published_at?->format('Y-m-d') ?? '-',
                ];
            });
        $rows[] = [];

        $rows[] = ['=== TOP COUNTRIES ==='];
        $rows[] = ['Country', 'Visits'];
        SiteVisit::select('country', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('country')->where('country', '!=', '')
            ->groupBy('country')->orderBy('count', 'desc')->limit(20)->get()
            ->each(fn($c) => $rows[] = [$c->country, $c->count]);
        $rows[] = [];

        $rows[] = ['=== DEVICE BREAKDOWN ==='];
        $rows[] = ['Device', 'Visits'];
        SiteVisit::select('device_type', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('device_type')->get()
            ->each(fn($d) => $rows[] = [$d->device_type, $d->count]);

        $csv = '';
        foreach ($rows as $row) {
            $csv .= implode(',', array_map(fn($v) => '"' . str_replace('"', '""', $v) . '"', $row)) . "\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="report_' . now()->format('Y-m-d') . '.csv"');
    }
}
