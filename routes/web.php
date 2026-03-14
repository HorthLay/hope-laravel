<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminEmailController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChildDocumentController;
use App\Http\Controllers\ChildMediaController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\ChildUpdateController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\FamilyDocumentController;
use App\Http\Controllers\FamilyMediaController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\FamilyUpdateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PublicChildController;
use App\Http\Controllers\PublicFamilyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SponsorAdminController;
use App\Http\Controllers\SponsorAuthController;
use App\Http\Controllers\SponsorContactController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\SponsorDashboardController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\VerifyHumanController;
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
// Route::get('/what-we-do', [HomeController::class, 'learnmore'])->name('learn-more');
Route::get('/contact',    [HomeController::class, 'contact'])->name('contact');
Route::get('/about',      [HomeController::class, 'about'])->name('about');
Route::get('/privacy-policy',   [HomeController::class, 'privacy'])->name('privacy-policy');
Route::get('/terms-of-service', [HomeController::class, 'terms'])->name('terms-of-service');

Route::get('/verify-human', [VerifyHumanController::class, 'show'])
    ->name('verify.human');

Route::post('/verify-human/submit', [VerifyHumanController::class, 'submit'])
    ->name('verify.human.submit');


Route::get('/sponsor',      [SponsorController::class, 'index'])->name('sponsor.children');
// Encrypted slug routes
Route::get('/families/{family}', action: [PublicFamilyController::class, 'show'])->name('families.show');

// Public child detail page  
Route::get('/children/{child}', [PublicChildController::class, 'show'])->name('children.show');
// Public family detail page
Route::get('/articles/{slug}',       [HomeController::class, 'articleDetails'])->name('articles.show');
Route::get('/categories/{category}', [HomeController::class, 'categoryArticles'])->name('category.articles');
Route::get('/login/sponsor', [SponsorAuthController::class, 'showLogin'])->name('sponsor.login');
Route::post('/login/sponsor', [SponsorAuthController::class, 'login']);

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

        // Child Updates
        Route::post('children/{child}/updates', [ChildUpdateController::class, 'store'])
            ->name('admin.children.updates.store');
        Route::delete('children/{child}/updates/{update}', [ChildUpdateController::class, 'destroy'])
            ->name('admin.children.updates.destroy');

        // Child Media
        Route::post('children/{child}/media', [ChildMediaController::class, 'store'])
            ->name('admin.children.media.store');
        Route::delete('children/{child}/media/{media}', [ChildMediaController::class, 'destroy'])
            ->name('admin.children.media.destroy');

        // Child Documents
        Route::post('children/{child}/documents', [ChildDocumentController::class, 'store'])
            ->name('admin.children.documents.store');
        Route::delete('children/{child}/documents/{document}', [ChildDocumentController::class, 'destroy'])
            ->name('admin.children.documents.destroy');



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

        // Family Updates
        Route::post('families/{family}/updates', [FamilyUpdateController::class, 'store'])
            ->name('admin.families.updates.store');
        Route::delete('families/{family}/updates/{update}', [FamilyUpdateController::class, 'destroy'])
            ->name('admin.families.updates.destroy');

        // Family Media
        Route::post('families/{family}/media', [FamilyMediaController::class, 'store'])
            ->name('admin.families.media.store');
        Route::delete('families/{family}/media/{media}', [FamilyMediaController::class, 'destroy'])
            ->name('admin.families.media.destroy');

        // Family Documents
        Route::post('families/{family}/documents', [FamilyDocumentController::class, 'store'])
            ->name('admin.families.documents.store');
        Route::delete('families/{family}/documents/{document}', [FamilyDocumentController::class, 'destroy'])
            ->name('admin.families.documents.destroy');


        // Family Member Management
        Route::get('/family-members/admin', [FamilyMemberController::class, 'index'])->name('admin.family-members.index');
        Route::get('/admin/family-members/create', [FamilyMemberController::class, 'create'])->name('admin.family-members.create');
        Route::post('/admin/family-members', [FamilyMemberController::class, 'store'])->name('admin.family-members.store');
        Route::get('/admin/family-members/{member}', [FamilyMemberController::class, 'show'])->name('admin.family-members.show');
        Route::get('/admin/family-members/{member}/edit', [FamilyMemberController::class, 'edit'])->name('admin.family-members.edit');
        Route::put('/admin/family-members/{member}', [FamilyMemberController::class, 'update'])->name('admin.family-members.update');
        Route::delete('/admin/family-members/{member}', [FamilyMemberController::class, 'destroy'])->name('admin.family-members.destroy');

        // Email Management
        Route::get('/emails',         [AdminEmailController::class, 'index'])->name('admin.emails.index');
        Route::post('/emails/preview',[AdminEmailController::class, 'preview'])->name('admin.emails.preview');
        Route::post('/emails/send',   [AdminEmailController::class, 'send'])->name('admin.emails.send');
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

    Route::prefix('about')->name('about.')->group(function () {
    Route::get('/presentation',          fn() => view('pages.about.presentation'))   ->name('presentation');
    Route::get('/vision-ethics',         fn() => view('pages.about.vision-ethics'))  ->name('vision');
    Route::get('/team',                  fn() => view('pages.about.team'))            ->name('team');
    Route::get('/partners',              fn() => view('pages.about.partners'))        ->name('partners');
    // Note: 'support-branches' is hidden for now (per PDF)
});





// ══════════════════════════════════════════════════════════════
// OUR ACTIONS — CHILDHOOD DEPARTMENT
// ══════════════════════════════════════════════════════════════
Route::prefix('our-actions/childhood')->name('childhood.')->group(function () {
    Route::get('/protection',            fn() => view('pages.childhood.protection'))          ->name('protection');
    Route::get('/health-nutrition',      fn() => view('pages.childhood.health-nutrition'))    ->name('health');
    Route::get('/education',             fn() => view('pages.childhood.education'))           ->name('education');
    Route::get('/personal-development',  fn() => view('pages.childhood.personal-development'))->name('development');
    Route::get('/childrens-homes',       fn() => view('pages.childhood.childrens-homes'))     ->name('homes');
});

// ══════════════════════════════════════════════════════════════
// OUR ACTIONS — FAMILY DEPARTMENT
// ══════════════════════════════════════════════════════════════
Route::prefix('our-actions/families')->name('families.')->group(function () {
    Route::get('/housing-stability',     fn() => view('pages.families.housing'))              ->name('housing');
    Route::get('/training-employment',   fn() => view('pages.families.training-employment'))  ->name('training');
    Route::get('/financial-support',     fn() => view('pages.families.financial-support'))    ->name('financial');
    Route::get('/health-wellbeing',      fn() => view('pages.families.health-wellbeing'))     ->name('health');
});

// ══════════════════════════════════════════════════════════════
// OUR ACTIONS — COMMUNITY DEPARTMENT
// ══════════════════════════════════════════════════════════════
Route::prefix('our-actions/community')->name('community.')->group(function () {
    Route::get('/infrastructure',        fn() => view('pages.community.infrastructure'))      ->name('infrastructure');
    Route::get('/water-sanitation',      fn() => view('pages.community.water-sanitation'))    ->name('water');
});

// ══════════════════════════════════════════════════════════════
// SPONSORSHIP
// ══════════════════════════════════════════════════════════════
Route::prefix('sponsor')->name('sponsor.')->group(function () {

    // Child sponsorship
    Route::prefix('child')->name('child.')->group(function () {
        Route::get('/how-it-works',      fn() => view('pages.sponsorship.child-file'))        ->name('file');
        Route::get('/stories',           fn() => view('pages.sponsorship.child-stories'))     ->name('stories');
        Route::get('/corporate',         fn() => view('pages.sponsorship.sponsor-as-company'))->name('corporate');
    });

    // Family sponsorship
    Route::prefix('family')->name('family.')->group(function () {
        Route::get('/how-it-works',      fn() => view('pages.sponsorship.family-file'))       ->name('file');
        Route::get('/stories',           fn() => view('pages.sponsorship.family-stories'))    ->name('stories');
        Route::get('/corporate',         fn() => view('pages.sponsorship.sponsor-as-company'))->name('corporate');
    });

    // FAQ
    Route::get('/faq',                   fn() => view('pages.sponsorship.faq'))               ->name('faq');
});

// ══════════════════════════════════════════════════════════════
// SUPPORT US
// ══════════════════════════════════════════════════════════════
Route::prefix('support')->name('support.')->group(function () {

    // Projects
    Route::get('/projects',              fn() => view('pages.support.ongoing-projects'))      ->name('projects');

    // Donations
    Route::get('/donate',                fn() => view('pages.support.donate'))                ->name('donate');
    // Route::get('/donate-ifi',            fn() => view('pages.support.donate-ifi'))            ->name('donate-ifi');
    Route::get('/bequests',              fn() => view('pages.support.bequests'))              ->name('bequests');
    Route::get('/fundraiser',            fn() => view('pages.support.fundraiser'))            ->name('fundraiser');
    Route::get('/donations-faq',         fn() => view('pages.support.faq-donations'))         ->name('faq-donations');

    // Events
    Route::get('/solidarity-event',      fn() => view('pages.support.solidarity-event'))      ->name('event');

    // Companies & Foundations
    Route::get('/patron',                fn() => view('pages.support.patron'))                ->name('patron');
    Route::get('/family-foundations',    fn() => view('pages.support.foundations-philanthropy'))->name('foundations');
    Route::get('/corporate-foundations', fn() => view('pages.support.corporate-foundations')) ->name('corporate');

    // Tax
    Route::get('/tax-benefits',          fn() => view('pages.support.tax-benefits'))          ->name('tax-benefits');
});
Auth::routes(['verify'=>true]);