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

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $dateRange = $request->get('range', '30');
        $startDate = now()->subDays($dateRange);
        $endDate   = now();

        // ── Overview stats ────────────────────────────────────────
        $stats = [
            'total_articles'    => Article::count(),
            'total_views'       => Article::sum('views_count'),
            'total_visits'      => SiteVisit::count(),
            'total_categories'  => Category::count(),
            'articles_growth'   => $this->calculateGrowth(
                Article::where('created_at', '>=', $startDate)->count(),
                Article::where('created_at', '>=', now()->subDays($dateRange * 2))
                    ->where('created_at', '<', $startDate)->count()
            ),
            'views_growth'      => $this->calculateGrowth(
                SiteVisit::where('created_at', '>=', $startDate)->count(),
                SiteVisit::where('created_at', '>=', now()->subDays($dateRange * 2))
                    ->where('created_at', '<', $startDate)->count()
            ),
        ];

        // ── Articles ──────────────────────────────────────────────
        $articlesByStatus = Article::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')->get()->pluck('count', 'status')->toArray();

        $topArticles = Article::with(['category', 'admin'])
            ->orderBy('views_count', 'desc')->limit(10)->get();

        $articlesByCategory = Category::withCount('articles')
            ->orderBy('articles_count', 'desc')->limit(10)->get();

        // ── Traffic ───────────────────────────────────────────────
        $trafficData = SiteVisit::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as visits')
            )->where('created_at', '>=', $startDate)
            ->groupBy('date')->orderBy('date')->get();

        if ($trafficData->isEmpty()) {
            $trafficData = collect([(object)['date' => now()->format('Y-m-d'), 'visits' => 0]]);
        }

        $articlesData = Article::select(
                DB::raw('DATE(published_at) as date'),
                DB::raw('count(*) as count')
            )->where('published_at', '>=', $startDate)
            ->whereNotNull('published_at')
            ->groupBy('date')->orderBy('date')->get();

        $trafficByDevice = array_merge(
            ['desktop' => 0, 'mobile' => 0, 'tablet' => 0],
            SiteVisit::select('device_type', DB::raw('count(*) as count'))
                ->where('created_at', '>=', $startDate)
                ->groupBy('device_type')->get()->pluck('count', 'device_type')->toArray()
        );

        $trafficByBrowser = SiteVisit::select('browser', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('browser')
            ->groupBy('browser')->orderBy('count', 'desc')->limit(5)->get();

        $topCountries = SiteVisit::select('country', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('country')->where('country', '!=', '')
            ->groupBy('country')->orderBy('count', 'desc')->limit(10)->get();

        $topAuthors = Admin::withCount([
                'articles' => fn($q) => $q->where('created_at', '>=', $startDate)
            ])->having('articles_count', '>', 0)
            ->orderBy('articles_count', 'desc')->limit(5)->get();

        $recentArticles = Article::with(['admin', 'category'])->latest()->limit(5)->get();

        // ════════════════════════════════════════════════════════
        // SPONSORSHIP ANALYTICS
        // ════════════════════════════════════════════════════════

        // ── Children ──────────────────────────────────────────────
        $totalChildren        = SponsoredChild::count();
        $activeChildren       = SponsoredChild::where('is_active', true)->count();
        $sponsoredChildren    = SponsoredChild::where('is_active', true)->whereHas('sponsors')->count();
        $unsponsoredChildren  = SponsoredChild::where('is_active', true)->whereDoesntHave('sponsors')->count();
        $newChildrenPeriod    = SponsoredChild::where('created_at', '>=', $startDate)->count();
        $childPct             = $activeChildren > 0 ? round($sponsoredChildren / $activeChildren * 100) : 0;

        $childrenGrowth = $this->calculateGrowth(
            $newChildrenPeriod,
            SponsoredChild::whereBetween('created_at', [now()->subDays($dateRange * 2), $startDate])->count()
        );

        // New children per day (trend)
        $childrenTrend = SponsoredChild::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )->where('created_at', '>=', $startDate)
            ->groupBy('date')->orderBy('date')->get();

        // ── Families ──────────────────────────────────────────────
        $totalFamilies        = Family::count();
        $activeFamilies       = Family::where('is_active', true)->count();
        $sponsoredFamilies    = Family::where('is_active', true)->whereHas('sponsors')->count();
        $unsponsoredFamilies  = Family::where('is_active', true)->whereDoesntHave('sponsors')->count();
        $totalFamilyMembers   = FamilyMember::count();
        $newFamiliesPeriod    = Family::where('created_at', '>=', $startDate)->count();
        $familyPct            = $activeFamilies > 0 ? round($sponsoredFamilies / $activeFamilies * 100) : 0;
        $avgMembersPerFamily  = $activeFamilies > 0 ? round($totalFamilyMembers / $activeFamilies, 1) : 0;

        $familiesGrowth = $this->calculateGrowth(
            $newFamiliesPeriod,
            Family::whereBetween('created_at', [now()->subDays($dateRange * 2), $startDate])->count()
        );

        // ── Sponsors ──────────────────────────────────────────────
        $totalSponsors        = Sponsor::count();
        $activeSponsors       = Sponsor::where('is_active', true)->count();
        $inactiveSponsors     = Sponsor::where('is_active', false)->count();
        $newSponsorsPeriod    = Sponsor::where('created_at', '>=', $startDate)->count();
        $sponsorsWithChildren = Sponsor::whereHas('children')->count();
        $sponsorsWithFamilies = Sponsor::whereHas('families')->count();
        $sponsorsWithBoth     = Sponsor::whereHas('children')->whereHas('families')->count();
        $sponsorsWithAny      = Sponsor::where(fn($q) => $q->whereHas('children')->orWhereHas('families'))->count();

        $sponsorsGrowth = $this->calculateGrowth(
            $newSponsorsPeriod,
            Sponsor::whereBetween('created_at', [now()->subDays($dateRange * 2), $startDate])->count()
        );

        // New sponsors per day (trend)
        $sponsorsTrend = Sponsor::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )->where('created_at', '>=', $startDate)
            ->groupBy('date')->orderBy('date')->get();

        $recentSponsors = Sponsor::latest()->take(6)->get();

        $topSponsors = Sponsor::withCount(['children', 'families'])
            ->having('children_count', '>', 0)
            ->orHaving('families_count', '>', 0)
            ->orderByRaw('children_count + families_count DESC')
            ->limit(6)->get();

        // ── Combined ──────────────────────────────────────────────
        $totalBeneficiaries = $activeChildren + $totalFamilyMembers;
        $totalSponsored     = $sponsoredChildren + $sponsoredFamilies;
        $totalUnsponsored   = $unsponsoredChildren + $unsponsoredFamilies;
        $overallPct         = ($activeChildren + $activeFamilies) > 0
                                ? round(($sponsoredChildren + $sponsoredFamilies) / ($activeChildren + $activeFamilies) * 100)
                                : 0;

        return view('admin.analytics.index', compact(
            // existing
            'stats', 'articlesByStatus', 'topArticles', 'articlesByCategory',
            'trafficData', 'articlesData', 'trafficByDevice', 'trafficByBrowser',
            'topCountries', 'topAuthors', 'recentArticles', 'dateRange',
            // children
            'totalChildren', 'activeChildren', 'sponsoredChildren',
            'unsponsoredChildren', 'newChildrenPeriod', 'childPct',
            'childrenGrowth', 'childrenTrend',
            // families
            'totalFamilies', 'activeFamilies', 'sponsoredFamilies',
            'unsponsoredFamilies', 'totalFamilyMembers', 'newFamiliesPeriod',
            'familyPct', 'avgMembersPerFamily', 'familiesGrowth',
            // sponsors
            'totalSponsors', 'activeSponsors', 'inactiveSponsors',
            'newSponsorsPeriod', 'sponsorsGrowth',
            'sponsorsWithChildren', 'sponsorsWithFamilies',
            'sponsorsWithBoth', 'sponsorsWithAny',
            'sponsorsTrend', 'recentSponsors', 'topSponsors',
            // combined
            'totalBeneficiaries', 'totalSponsored', 'totalUnsponsored', 'overallPct'
        ));
    }

    protected function calculateGrowth($current, $previous)
    {
        if ($previous == 0) return $current > 0 ? 100 : 0;
        return round((($current - $previous) / $previous) * 100, 1);
    }

    public function export(Request $request)
    {
        return response()->json(['message' => 'Export functionality coming soon']);
    }
}
