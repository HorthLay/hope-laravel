<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Article;
use App\Models\Category;
use App\Models\SiteVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
      public function index(Request $request)
    {
        // Date range filter
        $dateRange = $request->get('range', '30'); // Default 30 days
        $startDate = now()->subDays($dateRange);
        $endDate = now();

        // Overview Statistics
        $stats = [
            'total_articles' => Article::count(),
            'total_views' => Article::sum('views_count'),
            'total_visits' => SiteVisit::count(),
            'total_categories' => Category::count(),
            
            // Growth compared to previous period
            'articles_growth' => $this->calculateGrowth(
                Article::where('created_at', '>=', $startDate)->count(),
                Article::where('created_at', '>=', now()->subDays($dateRange * 2))
                    ->where('created_at', '<', $startDate)->count()
            ),
            'views_growth' => $this->calculateGrowth(
                SiteVisit::where('created_at', '>=', $startDate)->count(),
                SiteVisit::where('created_at', '>=', now()->subDays($dateRange * 2))
                    ->where('created_at', '<', $startDate)->count()
            ),
        ];

        // Articles by Status
        $articlesByStatus = Article::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Top Articles by Views
        $topArticles = Article::with(['category', 'admin'])
            ->orderBy('views_count', 'desc')
            ->limit(10)
            ->get();

        // Articles by Category
        $articlesByCategory = Category::withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->limit(10)
            ->get();

        // Traffic Over Time (Last 30 days)
        $trafficData = SiteVisit::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as visits')
            )
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // If no data, create empty collection with at least one entry for today
        if ($trafficData->isEmpty()) {
            $trafficData = collect([
                (object)['date' => now()->format('Y-m-d'), 'visits' => 0]
            ]);
        }

        // Articles Published Over Time
        $articlesData = Article::select(
                DB::raw('DATE(published_at) as date'),
                DB::raw('count(*) as count')
            )
            ->where('published_at', '>=', $startDate)
            ->whereNotNull('published_at')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Traffic by Device
        $trafficByDevice = SiteVisit::select('device_type', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('device_type')
            ->get()
            ->pluck('count', 'device_type')
            ->toArray();
        
        // Ensure all device types have a value
        $trafficByDevice = array_merge([
            'desktop' => 0,
            'mobile' => 0,
            'tablet' => 0
        ], $trafficByDevice);

        // Traffic by Browser
        $trafficByBrowser = SiteVisit::select('browser', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        // Top Countries (if you have country tracking)
        $topCountries = SiteVisit::select('country', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('country')
            ->where('country', '!=', '')
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        // Most Active Authors
        $topAuthors = Admin::withCount([
                'articles' => function($query) use ($startDate) {
                    $query->where('created_at', '>=', $startDate);
                }
            ])
            ->having('articles_count', '>', 0)
            ->orderBy('articles_count', 'desc')
            ->limit(5)
            ->get();

        // Recent Activity
        $recentArticles = Article::with(['admin', 'category'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.analytics.index', compact(
            'stats',
            'articlesByStatus',
            'topArticles',
            'articlesByCategory',
            'trafficData',
            'articlesData',
            'trafficByDevice',
            'trafficByBrowser',
            'topCountries',
            'topAuthors',
            'recentArticles',
            'dateRange'
        ));
    }

    /**
     * Calculate growth percentage
     */
    protected function calculateGrowth($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    /**
     * Export analytics data
     */
    public function export(Request $request)
    {
        // You can implement CSV/PDF export here
        return response()->json(['message' => 'Export functionality coming soon']);
    }
}
