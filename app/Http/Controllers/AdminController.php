<?php

namespace App\Http\Controllers;

use App\Helpers\NumberHelper;
use App\Models\Admin;
use App\Models\Article;
use App\Models\Category;
use App\Models\Image;
use App\Models\SiteVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        // ========== SITE VISIT STATISTICS ==========
        $totalSiteVisits          = SiteVisit::count();
        $totalSiteVisitsFormatted = NumberHelper::formatNumber($totalSiteVisits);
        $uniqueVisitors           = SiteVisit::uniqueVisitors();
        $uniqueVisitorsFormatted  = NumberHelper::formatNumber($uniqueVisitors);
        $siteVisitsThisMonth      = SiteVisit::totalVisits(now()->startOfMonth());
        $siteVisitsLastMonth      = SiteVisit::totalVisits(now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth());
        $siteVisitsGrowth         = $siteVisitsLastMonth > 0
                                        ? round((($siteVisitsThisMonth - $siteVisitsLastMonth) / $siteVisitsLastMonth) * 100)
                                        : 0;
        $visitsToday              = SiteVisit::totalVisits(now()->startOfDay());
        $visitsTodayFormatted     = NumberHelper::formatNumber($visitsToday);
        $uniqueVisitorsToday      = SiteVisit::uniqueVisitors(now()->startOfDay());
        $uniqueVisitorsTodayFormatted = NumberHelper::formatNumber($uniqueVisitorsToday);
        $visitsThisWeek           = SiteVisit::totalVisits(now()->startOfWeek());
        $visitsThisWeekFormatted  = NumberHelper::formatNumber($visitsThisWeek);
        $visitsByDevice           = SiteVisit::byDeviceType();
        $topPages                 = SiteVisit::topPages(5);
        $visitsTrend              = SiteVisit::visitsTrend(7);

        // ========== COUNTRY STATISTICS ==========
        $topCountries    = SiteVisit::byCountry(5, now()->subDays(30));
        $topCities       = SiteVisit::byCity(5, now()->subDays(30));
        $uniqueCountries = SiteVisit::uniqueCountries();

        // ========== ARTICLE STATISTICS ==========
        $totalArticles    = Article::count();
        $publishedArticles = Article::where('status', 'published')->count();
        $draftArticles    = Article::where('status', 'draft')->count();
        $totalViews       = Article::sum('views_count');
        $totalViewsFormatted = NumberHelper::formatNumber($totalViews);
        $viewsThisMonth   = Article::where('created_at', '>=', now()->startOfMonth())->sum('views_count');
        $viewsThisMonthFormatted = NumberHelper::formatNumber($viewsThisMonth);
        $viewsToday       = Article::where('created_at', '>=', now()->startOfDay())->sum('views_count');
        $viewsLastMonth   = Article::whereBetween('created_at', [
                                now()->subMonth()->startOfMonth(),
                                now()->subMonth()->endOfMonth()
                            ])->sum('views_count');
        $viewsGrowth      = $viewsLastMonth > 0
                                ? round((($viewsThisMonth - $viewsLastMonth) / $viewsLastMonth) * 100)
                                : 0;

        // ========== MEDIA STATISTICS ==========
        $totalImages          = Image::count();
        $totalImagesFormatted = NumberHelper::formatNumber($totalImages);
        $imagesThisMonth      = Image::where('created_at', '>=', now()->startOfMonth())->count();
        $imagesThisMonthFormatted = NumberHelper::formatNumber($imagesThisMonth);
        $totalStorageBytes    = Image::sum('file_size');
        $totalStorageFormatted = NumberHelper::formatBytes($totalStorageBytes);

        // ========== OTHER ==========
        $totalCategories  = Category::count();
        $articlesThisWeek = Article::where('created_at', '>=', now()->subWeek())
                                ->where('status', 'published')->count();
        $recentArticles   = Article::with(['category', 'image', 'admin'])->latest()->take(10)->get();
        $draftCount       = $draftArticles;

        // ========== CHILDREN STATISTICS ==========
        $totalChildren        = \App\Models\SponsoredChild::count();
        $activeChildren       = \App\Models\SponsoredChild::where('is_active', true)->count();
        $sponsoredChildren    = \App\Models\SponsoredChild::where('is_active', true)->whereHas('sponsors')->count();
        $unsponsoredChildren  = \App\Models\SponsoredChild::where('is_active', true)->whereDoesntHave('sponsors')->count();
        $childrenCountries    = \App\Models\SponsoredChild::where('is_active', true)
                                    ->whereNotNull('country')->distinct('country')->count('country');
        $newChildrenThisMonth = \App\Models\SponsoredChild::where('created_at', '>=', now()->startOfMonth())->count();
        $recentChildren       = \App\Models\SponsoredChild::with('sponsors')->latest()->take(6)->get();

        // ========== FAMILY STATISTICS ==========
        $totalFamilies        = \App\Models\Family::count();
        $activeFamilies       = \App\Models\Family::where('is_active', true)->count();
        $sponsoredFamilies    = \App\Models\Family::where('is_active', true)->whereHas('sponsors')->count();
        $unsponsoredFamilies  = \App\Models\Family::where('is_active', true)->whereDoesntHave('sponsors')->count();
        $totalFamilyMembers   = \App\Models\FamilyMember::count();
        $newFamiliesThisMonth = \App\Models\Family::where('created_at', '>=', now()->startOfMonth())->count();
        $recentFamilies       = \App\Models\Family::withCount('members')->with('sponsors')->latest()->take(6)->get();

        return view('admin.dashboard', compact(
            // Site visits
            'totalSiteVisits', 'totalSiteVisitsFormatted',
            'uniqueVisitors', 'uniqueVisitorsFormatted',
            'siteVisitsThisMonth', 'siteVisitsGrowth',
            'visitsToday', 'visitsTodayFormatted',
            'uniqueVisitorsToday', 'uniqueVisitorsTodayFormatted',
            'visitsThisWeek', 'visitsThisWeekFormatted',
            'visitsByDevice', 'topPages', 'visitsTrend',
            // Countries
            'topCountries', 'topCities', 'uniqueCountries',
            // Articles
            'totalArticles', 'publishedArticles', 'draftArticles',
            'totalViews', 'totalViewsFormatted',
            'viewsThisMonth', 'viewsThisMonthFormatted',
            'viewsToday', 'viewsGrowth',
            // Media
            'totalImages', 'totalImagesFormatted',
            'imagesThisMonth', 'imagesThisMonthFormatted',
            'totalStorageBytes', 'totalStorageFormatted',
            // Other
            'totalCategories', 'articlesThisWeek', 'recentArticles', 'draftCount',
            // Children
            'totalChildren', 'activeChildren', 'sponsoredChildren',
            'unsponsoredChildren', 'childrenCountries',
            'newChildrenThisMonth', 'recentChildren',
            // Families
            'totalFamilies', 'activeFamilies', 'sponsoredFamilies',
            'unsponsoredFamilies', 'totalFamilyMembers',
            'newFamiliesThisMonth', 'recentFamilies'
        ));
    }


     public function admincreatedview(Request $request)
    {
        $query = Admin::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        // Get paginated results
        $admins = $query->latest()->paginate(15)->withQueryString();

        // Calculate stats
        $totalAdmins = Admin::count();
        $activeAdmins = Admin::where('is_active', true)->count();
        $superAdmins = Admin::where('role', 'super_admin')->count();

        return view('admin.admins.index', compact(
            'admins',
            'totalAdmins',
            'activeAdmins',
            'superAdmins'
        ));
    }

    /**
     * Display a listing of admins (standard index)
     */


    /**
     * Show the form for creating a new admin
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created admin in the database
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin,editor',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Please enter the admin name.',
            'email.required' => 'Please enter an email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'role.required' => 'Please select a role.',
        ]);

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);
        
        // Set active status (default to true if not provided)
        $validated['is_active'] = $request->has('is_active') ? true : false;

        // Create the admin
        $admin = Admin::create($validated);

        // Redirect with success message
        return redirect()
            ->route('admin.admins.index')
            ->with('success', "Admin '{$admin->name}' has been created successfully!");
    }

    /**
     * Display the specified admin
     */
    public function show(Admin $admin)
    {
        // Load relationships if needed
        $admin->load(['articles']);

        // Get admin statistics
        $stats = [
            'total_articles' => $admin->articles()->count(),
            'published_articles' => $admin->articles()->where('status', 'published')->count(),
            'draft_articles' => $admin->articles()->where('status', 'draft')->count(),
            'member_since' => $admin->created_at->diffForHumans(),
            'last_login' => $admin->last_login_at ? $admin->last_login_at->diffForHumans() : 'Never',
        ];

        return view('admin.admins.show', compact('admin', 'stats'));
    }

    /**
     * Show the form for editing the specified admin
     */
    public function edit(Admin $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified admin in the database
     */
    public function update(Request $request, Admin $admin)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('admins')->ignore($admin->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin,editor',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Please enter the admin name.',
            'email.required' => 'Please enter an email address.',
            'email.unique' => 'This email is already registered.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'role.required' => 'Please select a role.',
        ]);

        // Only update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Set active status
        $validated['is_active'] = $request->has('is_active') ? true : false;

        // Update the admin
        $admin->update($validated);

        // Redirect with success message
        return redirect()
            ->route('admin.admins.index')
            ->with('success', "Admin '{$admin->name}' has been updated successfully!");
    }

    /**
     * Remove the specified admin from the database
     */
    public function destroy(Admin $admin)
    {
        // Prevent deleting yourself
        if ($admin->id === auth()->guard('admin')->id()) {
            return redirect()
                ->route('admin.admins.index')
                ->with('error', 'You cannot delete your own account!');
        }

        // Prevent deleting the last super admin
        if ($admin->role === 'super_admin') {
            $superAdminCount = Admin::where('role', 'super_admin')->count();
            
            if ($superAdminCount <= 1) {
                return redirect()
                    ->route('admin.admins.index')
                    ->with('error', 'Cannot delete the last Super Admin. The system must have at least one Super Admin.');
            }
        }

        // Store the name for the success message
        $adminName = $admin->name;

        // Delete the admin
        $admin->delete();

        // Redirect with success message
        return redirect()
            ->route('admin.admins.index')
            ->with('success', "Admin '{$adminName}' has been deleted successfully!");
    }

    /**
     * Toggle admin active status
     */
    public function toggleStatus(Admin $admin)
    {
        // Prevent deactivating yourself
        if ($admin->id === auth()->guard('admin')->id()) {
            return redirect()
                ->route('admin.admins.index')
                ->with('error', 'You cannot deactivate your own account!');
        }

        // Toggle the status
        $admin->is_active = !$admin->is_active;
        $admin->save();

        $status = $admin->is_active ? 'activated' : 'deactivated';

        return redirect()
            ->route('admin.admins.index')
            ->with('success', "Admin '{$admin->name}' has been {$status} successfully!");
    }
}
