<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\Category;
use App\Models\Setting;
use App\Models\SiteVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
class HomeController extends Controller
{
       // ──────────────────────────────────────────────────────────────────────
    //  HOME
    // ──────────────────────────────────────────────────────────────────────
       // ──────────────────────────────────────────────────────────────────────
    //  HOME
    // ──────────────────────────────────────────────────────────────────────
    public function index()
    {
        $settings = $this->getCachedJsonSettings();

        // Cache all homepage data for 10 minutes
        $homeData = \Illuminate\Support\Facades\Cache::remember('home_data', 600, function () {
            $articles = Article::with(['category', 'image', 'tags'])
                ->published()
                ->orderBy('published_at', 'desc')
                ->get()
                ->map(fn($a) => $this->encryptArticle($a));

            $successStory = Article::with(['category', 'image', 'tags'])
                ->published()
                ->featured()
                ->orderBy('published_at', 'desc')
                ->first();
            if ($successStory) {
                $successStory = $this->encryptArticle($successStory);
            }

            $videoArticles = Article::with(['category', 'image', 'tags'])
                ->published()
                ->whereNotNull('video_url')
                ->where('video_url', '!=', '')
                ->orderBy('published_at', 'desc')
                ->limit(3)
                ->get()
                ->map(function ($a) {
                    $a = $this->encryptArticle($a);
                    $a->embed_url = $this->getYoutubeEmbedUrl($a->video_url);
                    return $a;
                });

            $categories = Category::active()
                ->withCount(['articles' => fn($q) => $q->published()])
                ->ordered()
                ->get()
                ->map(fn($c) => $this->encryptCategory($c));

            $categoryArticles = $categories->take(3)->mapWithKeys(function ($cat) {
                $articles = Article::with(['category', 'image', 'tags'])
                    ->published()
                    ->where('category_id', $cat->id)
                    ->orderBy('published_at', 'desc')
                    ->limit(4)
                    ->get()
                    ->map(fn($a) => $this->encryptArticle($a));
                return [$cat->id => $articles];
            });

            $popupArticle = Article::with(['category', 'image'])
                ->published()
                ->orderBy('views_count', 'desc')
                ->first();
            if ($popupArticle) {
                $this->encryptArticle($popupArticle);
            }

            $unsponsoredChildren = \App\Models\SponsoredChild::where('is_active', true)
                ->whereDoesntHave('sponsors')
                ->inRandomOrder()
                ->limit(6)
                ->get();

            $unsponsoredFamilies = \App\Models\Family::where('is_active', true)
                ->whereDoesntHave('sponsors')
                ->withCount('members')
                ->inRandomOrder()
                ->limit(4)
                ->get();

            $stats = [
                'total_articles'   => Article::published()->count(),
                'total_categories' => Category::active()->count(),
                'total_views'      => Article::sum('views_count') ?? 0,
                'total_children'   => \App\Models\SponsoredChild::where('is_active', true)->count(),
                'total_countries'  => \App\Models\SponsoredChild::where('is_active', true)
                                        ->whereNotNull('country')
                                        ->distinct('country')
                                        ->count('country'),
            ];

            return compact(
                'articles',
                'successStory',
                'videoArticles',
                'categories',
                'categoryArticles',
                'popupArticle',
                'unsponsoredChildren',
                'unsponsoredFamilies',
                'stats'
            );
        });

        // Extract variables from cache
        extract($homeData);

        $this->trackVisit(request());

        return view('home', compact(
            'articles',
            'successStory',
            'videoArticles',
            'categories',
            'categoryArticles',
            'stats',
            'popupArticle',
            'unsponsoredChildren',
            'unsponsoredFamilies',
            'settings'
        ));
    }
    // ──────────────────────────────────────────────────────────────────────
    //  ARTICLE DETAIL  /articles/{slug}
    // ──────────────────────────────────────────────────────────────────────
    public function articleDetails(string $slug)
    {
        try {
            $realSlug = Crypt::decryptString($slug);
        } catch (\Exception $e) {
            $realSlug = $slug; // fallback plain slug
        }

        $article = Article::with(['category', 'image', 'admin', 'tags'])
            ->published()
            ->where('slug', $realSlug)
            ->firstOrFail();

        // Encrypt slugs on the article AND its nested category
        $this->encryptArticle($article);

        $article->increment('views_count');

        $related = Article::with(['category', 'image'])
            ->published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get()
            ->map(fn($a) => $this->encryptArticle($a));

        $prevArticle = Article::published()
            ->where('published_at', '<', $article->published_at)
            ->orderBy('published_at', 'desc')
            ->first();

        $nextArticle = Article::published()
            ->where('published_at', '>', $article->published_at)
            ->orderBy('published_at', 'asc')
            ->first();

        if ($prevArticle) $prevArticle = $this->encryptArticle($prevArticle);
        if ($nextArticle) $nextArticle = $this->encryptArticle($nextArticle);

        $this->trackVisit(request());

        $settings = $this->getCachedJsonSettings();

        return view('articles.show', compact(
            'article',
            'related',
            'prevArticle',
            'nextArticle',
            'settings'
        ));
    }

    // ──────────────────────────────────────────────────────────────────────
    //  CATEGORY ARTICLES  /categories/{category}
    // ──────────────────────────────────────────────────────────────────────
    public function categoryArticles(string $category)
    {
        try {
            $realSlug = Crypt::decryptString($category);
        } catch (\Exception $e) {
            $realSlug = $category;
        }

        $category = Category::active()
            ->where('slug', $realSlug)
            ->firstOrFail();

        $articles = Article::with(['category', 'image'])
            ->published()
            ->where('category_id', $category->id)
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $articles->getCollection()->transform(fn($a) => $this->encryptArticle($a));

        $categories = Category::active()
            ->withCount(['articles' => fn($q) => $q->published()])
            ->ordered()
            ->get()
            ->map(fn($c) => $this->encryptCategory($c));

        $this->trackVisit(request());


        $settings = $this->getCachedJsonSettings();

        return view('categories.articles', compact(
            'category',
            'articles',
            'categories',
            'settings'
        ));
    }

    // ──────────────────────────────────────────────────────────────────────
    //  STATIC PAGES
    // ──────────────────────────────────────────────────────────────────────
    public function learnmore()
    {
        $featuredArticles = Article::with(['category', 'image'])
            ->published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get()
            ->map(fn($a) => $this->encryptArticle($a));
        $settings = $this->getCachedJsonSettings();

        return view('pages.learn-more', compact('featuredArticles', 'settings'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function about()
    {
        $stats = [
            'total_articles'   => Article::published()->count(),
            'total_categories' => Category::active()->count(),
            'total_views'      => Article::sum('views_count'),
        ];

        return view('pages.about', compact('stats'));
    }

    public function privacy()
    {
        $settings = $this->getCachedJsonSettings();
        return view('pages.privacy-policy',compact('settings'));
    }

    public function terms()
    {
        $settings = $this->getCachedJsonSettings();
        return view('pages.terms-of-service',compact('settings'));
    }

  

    // ──────────────────────────────────────────────────────────────────────
    //  SITE SETTINGS HELPER  (reads from Setting model / DB)
    // ──────────────────────────────────────────────────────────────────────
    private function getSiteSettings(): array
    {
        $defaults = [
            'site_name'       => 'Hope & Impact',
            'facebook_url'    => '',
            'twitter_url'     => '',
            'instagram_url'   => '',
            'youtube_url'     => '',
            'linkedin_url'    => '',
            'telegram_url'    => '',
            'whatsapp_url'    => '',
            'x_url'           => '',
            'khqr_image'      => '',
            'account_name'    => 'Hope & Impact Foundation',
            'account_bank'    => 'ABA Bank · Phnom Penh, Cambodia',
            'contact_email'   => '',
            'contact_phone'   => '',
        ];

        try {
            return array_merge($defaults, Setting::getAllSettings());
        } catch (\Exception $e) {
            return $defaults; // DB not ready yet — never crash the public page
        }
    }

    // ──────────────────────────────────────────────────────────────────────
    //  YOUTUBE EMBED URL HELPER
    // ──────────────────────────────────────────────────────────────────────
    private function getYoutubeEmbedUrl(string $url): string
    {
        // Match youtu.be/ID or youtube.com/watch?v=ID or youtube.com/embed/ID
        preg_match(
            '/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_\-]{11})/',
            $url,
            $matches
        );
        $id = $matches[1] ?? null;
        return $id
            ? "https://www.youtube.com/embed/{$id}?rel=0&modestbranding=1"
            : $url; // fallback: return as-is
    }

    // ──────────────────────────────────────────────────────────────────────
    //  ENCRYPT HELPERS
    // ──────────────────────────────────────────────────────────────────────
    private function encryptArticle(Article $article): Article
    {
        $article->encrypted_id   = Crypt::encryptString((string) $article->id);
        $article->encrypted_slug = Crypt::encryptString($article->slug);

        // Encrypt nested category so $article->category->encrypted_slug works in Blade
        if ($article->relationLoaded('category') && $article->category) {
            $this->encryptCategory($article->category);
        }

        return $article;
    }

    private function encryptCategory(Category $category): Category
    {
        $category->encrypted_id   = Crypt::encryptString((string) $category->id);
        $category->encrypted_slug = Crypt::encryptString($category->slug);
        return $category;
    }

    // ──────────────────────────────────────────────────────────────────────
    //  VISIT TRACKING
    // ──────────────────────────────────────────────────────────────────────
    private function trackVisit(Request $request): void
    {
        try {
            $ua         = $request->userAgent() ?? '';
            $ip         = $request->ip();
            $deviceType = $this->detectDevice($ua);

            // ── Deduplication: same IP + device = count as 1 ────────────
            $dedupeKey = 'site_visit:' . md5($ip . '|' . $deviceType);
            if (\Illuminate\Support\Facades\Cache::has($dedupeKey)) {
                return; // Already counted this visitor in the last 30 min
            }
            \Illuminate\Support\Facades\Cache::put($dedupeKey, true, now()->addMinutes(30));
            // ─────────────────────────────────────────────────────────────

            SiteVisit::create([
                'ip_address'  => $ip,
                'user_agent'  => $ua,
                'device_type' => $deviceType,
                'browser'     => $this->detectBrowser($ua),
                'page_url'    => $request->fullUrl(),
                'country'     => session('visitor_country'),
            ]);
        } catch (\Exception $e) {
            // Never crash page on tracking failure
        }
    }

    private function detectDevice(string $ua): string
    {
        if (preg_match('/tablet|ipad|playbook|silk/i', $ua))                              return 'tablet';
        if (preg_match('/mobile|iphone|ipod|android|blackberry|windows\sce|palm/i', $ua)) return 'mobile';
        return 'desktop';
    }

    private function detectBrowser(string $ua): string
    {
        if (str_contains($ua, 'Edg'))                                return 'Edge';
        if (str_contains($ua, 'OPR') || str_contains($ua, 'Opera')) return 'Opera';
        if (str_contains($ua, 'Chrome'))                             return 'Chrome';
        if (str_contains($ua, 'Firefox'))                            return 'Firefox';
        if (str_contains($ua, 'Safari'))                             return 'Safari';
        return 'Other';
    }

    // ──────────────────────────────────────────────────────────────────────
    //  JSON SETTINGS CACHED HELPER
    // ──────────────────────────────────────────────────────────────────────
    private function getCachedJsonSettings(): array
    {
        return \Illuminate\Support\Facades\Cache::remember('site_settings_json', 3600, function () {
            $settingsFile = storage_path('app/settings.json');
            return file_exists($settingsFile)
                ? json_decode(file_get_contents($settingsFile), true)
                : [];
        });
    }

}
