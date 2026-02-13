<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Article;
use App\Models\Category;
use App\Models\SiteVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
 
    public function index(Request $request)
    {
        $range = $request->get('range', 30);
        $startDate = now()->subDays($range);

        // Overview stats
        $totalViews        = Article::sum('views_count');
        $publishedArticles = Article::where('status', 'published')->count();
        $draftArticles     = Article::where('status', 'draft')->count();
        $totalVisits       = SiteVisit::count();
        $totalCategories   = Category::count();
        $totalAdmins       = Admin::count();
        $newArticles       = Article::where('created_at', '>=', $startDate)->count();

        // Growth vs previous period
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

        // Top articles by views
        $topArticles = Article::with(['category', 'image'])
            ->orderBy('views_count', 'desc')
            ->limit(10)
            ->get();

        // Articles by status
        $articlesByStatus = Article::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Top categories
        $topCategories = Category::withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->limit(8)
            ->get();

        // Traffic by device
        $rawDevice = SiteVisit::select('device_type', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('device_type')
            ->get()
            ->pluck('count', 'device_type')
            ->toArray();
        $deviceStats = array_merge(['desktop' => 0, 'mobile' => 0, 'tablet' => 0], $rawDevice);
        $totalDevices = max(array_sum($deviceStats), 1);

        // Traffic by browser
        $browserStats = SiteVisit::select('browser', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();
        $totalBrowsers = max($browserStats->sum('count'), 1);

        // Top countries
        $topCountries = SiteVisit::select('country', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('country')
            ->where('country', '!=', '')
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->limit(8)
            ->get();
        $totalCountries = max($topCountries->sum('count'), 1);

        // Most active authors
        $topAuthors = Admin::withCount('articles')
            ->having('articles_count', '>', 0)
            ->orderBy('articles_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.reports.index', compact(
            'range',
            'totalViews',
            'publishedArticles',
            'draftArticles',
            'totalVisits',
            'totalCategories',
            'totalAdmins',
            'newArticles',
            'visitsGrowth',
            'articlesGrowth',
            'topArticles',
            'articlesByStatus',
            'topCategories',
            'deviceStats',
            'totalDevices',
            'browserStats',
            'totalBrowsers',
            'topCountries',
            'totalCountries',
            'topAuthors'
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
            ->each(function ($c) use (&$rows) {
                $rows[] = [$c->country, $c->count];
            });
        $rows[] = [];

        $rows[] = ['=== DEVICE BREAKDOWN ==='];
        $rows[] = ['Device', 'Visits'];
        SiteVisit::select('device_type', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('device_type')->get()
            ->each(function ($d) use (&$rows) {
                $rows[] = [$d->device_type, $d->count];
            });

        $csv = '';
        foreach ($rows as $row) {
            $csv .= implode(',', array_map(fn($v) => '"' . str_replace('"', '""', $v) . '"', $row)) . "\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="report_' . now()->format('Y-m-d') . '.csv"');
    }
}
