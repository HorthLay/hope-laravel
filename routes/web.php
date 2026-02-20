<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SponsorAdminController;
use App\Http\Controllers\SponsorAuthController;
use App\Http\Controllers\SponsorContactController;
use App\Http\Controllers\SponsorDashboardController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/learn-more', [HomeController::class, 'learnmore'])->name('learn-more');
Route::get('/contact',    [HomeController::class, 'contact'])->name('contact');
Route::get('/about',      [HomeController::class, 'about'])->name('about');
Route::get('/privacy-policy',   [HomeController::class, 'privacy'])->name('privacy-policy');
Route::get('/terms-of-service', [HomeController::class, 'terms'])->name('terms-of-service');
Route::get('/details',    [HomeController::class, 'details'])->name('detail');
// Route::get('/donate',      [DonationController::class, 'donate'])->name('donate');
Route::post('/webhooks/every-org', [DonationController::class, 'handleWebhook']);
// Encrypted slug routes
Route::get('/articles/{slug}',       [HomeController::class, 'articleDetails'])->name('articles.show');
Route::get('/categories/{category}', [HomeController::class, 'categoryArticles'])->name('category.articles');
Route::get('/login/sponsor', [SponsorAuthController::class, 'showLogin'])->name('sponsor.login');
 Route::post('/login/sponsor', [SponsorAuthController::class, 'login']);
Route::get('/sponsor',     [HomeController::class, 'sponsorshow'])->name('sponsor');

Route::prefix('admin')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [LoginController::class, 'login'])->name('admin.login.post');
        Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

        // ========== ARTICLES MANAGEMENT ==========
        Route::get('/articles', [ArticleController::class, 'index'])->name('admin.articles.index');
        Route::get('/articles/create', [ArticleController::class, 'create'])->name('admin.articles.create');
        Route::post('/articles', [ArticleController::class, 'store'])->name('admin.articles.store');
        Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('admin.articles.show');
        Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('admin.articles.edit');
        Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('admin.articles.update');
        Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('admin.articles.destroy');
        

          
        // ========== CATEGORIES MANAGEMENT ==========
        Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('admin.categories.show');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

        // ========= ADMINS MANAGEMENT ==========
        Route::get('/admins/created', [AdminController::class, 'admincreatedview'])->name('admin.admins.index');
        Route::get('/admins/create', [AdminController::class, 'create'])->name('admin.admins.create');
        Route::post('/admins', [AdminController::class, 'store'])->name('admin.admins.store');
        Route::get('/admins/{admin}', [AdminController::class, 'show'])->name('admin.admins.show');
        Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admin.admins.edit');
        Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admin.admins.update');
        Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admin.admins.destroy');
        // ======== MEDIA MANAGEMENT ==========
        Route::get('/media', [MediaController::class, 'index'])->name('admin.media.index');
        Route::post('/media', [MediaController::class, 'store'])->name('admin.media.store');
        Route::put('/media/{image}', [MediaController::class, 'update'])->name('admin.media.update');
        Route::delete('/media/{image}', [MediaController::class, 'destroy'])->name('admin.media.destroy');

        // ======== REPORTS MANAGEMENT ==========
        Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('admin.reports.export');
        // ======== SETTINGS MANAGEMENT ==========
        Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
        Route::post('/settings/cache', [SettingController::class, 'clearCache'])->name('admin.settings.cache');

        // ======== ANALYTICS MANAGEMENT ==========
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('admin.analytics.index');
        Route::post('/analytics/export', [AnalyticsController::class, 'export'])->name('admin.analytics.export');
        // Tag Management
        Route::get   ('/tags',       [TagController::class, 'index'  ])->name('admin.tags.index');
        Route::post  ('/tags',       [TagController::class, 'store'  ])->name('admin.tags.store');
        Route::put   ('/tags/{tag}', [TagController::class, 'update' ])->name('admin.tags.update');
        Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('admin.tags.destroy');
        // Report Management
        Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('admin.reports.export');
        // children mangement
    
        Route::get('/children/admin', [ChildrenController::class, 'index'])->name('admin.children.index');
        Route::get('/admin/children/create', [ChildrenController::class, 'create'])->name('admin.children.create');
        Route::post('/admin/children', [ChildrenController::class, 'store'])->name('admin.children.store');  
        Route::get('/admin/children/{child}', [ChildrenController::class, 'show'])->name('admin.children.show');
        Route::get('/admin/children/{child}/edit', [ChildrenController::class, 'edit'])->name('admin.children.edit');
        Route::put('/admin/children/{child}', [ChildrenController::class, 'update'])->name('admin.children.update');
        Route::delete('/admin/children/{child}', [ChildrenController::class, 'destroy'])->name('admin.children.destroy');

        // Sponsor Management
        Route::get('/sponsors/admin', [SponsorAdminController::class, 'index'])->name('admin.sponsors.index');
        Route::get('/admin/sponsors/create', [SponsorAdminController::class, 'create'])->name('admin.sponsors.create');
        Route::post('/admin/sponsors', [SponsorAdminController::class, 'store'])->name('admin.sponsors.store');
        Route::get('/admin/sponsors/{sponsor}', [SponsorAdminController::class, 'show'])->name('admin.sponsors.show');
        Route::get('/admin/sponsors/{sponsor}/edit', [SponsorAdminController::class, 'edit'])->name('admin.sponsors.edit');
        Route::put('/admin/sponsors/{sponsor}', [SponsorAdminController::class, 'update'])->name('admin.sponsors.update');
        Route::delete('/admin/sponsors/{sponsor}', [SponsorAdminController::class, 'destroy'])->name('admin.sponsors.destroy');

        // Family Management
        Route::get('/families/admin', [FamilyController::class, 'index'])->name('admin.families.index');
        Route::get('/admin/families/create', [FamilyController::class, 'create'])->name('admin.families.create');
        Route::post('/admin/families', [FamilyController::class, 'store'])->name('admin.families.store');
        Route::get('/admin/families/{family}', [FamilyController::class, 'show'])->name('admin.families.show');
        Route::get('/admin/families/{family}/edit', [FamilyController::class, 'edit'])->name('admin.families.edit');
        Route::put('/admin/families/{family}', [FamilyController::class, 'update'])->name('admin.families.update');
        Route::delete('/admin/families/{family}', [FamilyController::class, 'destroy'])->name('admin.families.destroy');
        // Family Member Management
        Route::get('/family-members/admin', [FamilyMemberController::class, 'index'])->name('admin.family-members.index');
        Route::get('/admin/family-members/create', [FamilyMemberController::class, 'create'])->name('admin.family-members.create');
        Route::post('/admin/family-members', [FamilyMemberController::class, 'store'])->name('admin.family-members.store');
        Route::get('/admin/family-members/{member}', [FamilyMemberController::class, 'show'])->name('admin.family-members.show');
        Route::get('/admin/family-members/{member}/edit', [FamilyMemberController::class, 'edit'])->name('admin.family-members.edit');
        Route::put('/admin/family-members/{member}', [FamilyMemberController::class, 'update'])->name('admin.family-members.update');
        Route::delete('/admin/family-members/{member}', [FamilyMemberController::class, 'destroy'])->name('admin.family-members.destroy');
            // ======== END OF ADMIN ROUTES ==========
    });
});


    // ── Protected (authenticated sponsors only) ────────────────────
    Route::middleware('sponsor.auth')->group(function () {
        Route::get('/dashboard', [SponsorDashboardController::class, 'index'])->name('sponsor.dashboard');
        Route::get('/download/{type}/{id}', [SponsorDashboardController::class, 'download'])->name('sponsor.download');
        Route::post('/logout/sponsor', [SponsorAuthController::class, 'logout'])->name('sponsor.logout');
        Route::post('/sponsor/child',     [HomeController::class, 'sponsor'])->name('sponsor.child');
    });


   
    Route::get('/contact/created', [SponsorContactController::class, 'show'])->name('sponsor.contact');
    Route::post('/contact', [SponsorContactController::class, 'submit'])->name('sponsor.contact.submit');


Auth::routes(['verify'=>true]);