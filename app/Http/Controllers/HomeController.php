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
        // All published articles — used for both the news grid and the most-read ranked list
        $articles = Article::with(['category', 'image', 'tags'])
            ->published()
            ->orderBy('published_at', 'desc')
            ->get()
            ->map(fn($a) => $this->encryptArticle($a));

        // Featured success story
        $successStory = Article::with(['category', 'image', 'tags'])
            ->published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->first();

        if ($successStory) {
            $successStory = $this->encryptArticle($successStory);
        }

        // Video articles — articles with a YouTube/video URL
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

        // Categories for nav + filtering
        $categories = Category::active()
            ->withCount(['articles' => fn($q) => $q->published()])
            ->ordered()
            ->get()
            ->map(fn($c) => $this->encryptCategory($c));

        // Per-category article groups (first 3 categories, up to 4 articles each)
        // Each article keeps its own $article->style for the card partial
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

        $stats = [
            'total_articles'   => Article::published()->count(),
            'total_categories' => Category::active()->count(),
            'total_views'      => Article::sum('views_count'),
        ];

        // Most-viewed article for popup
        $popupArticle = Article::with(['category', 'image'])
            ->published()
            ->orderBy('views_count', 'desc')
            ->first();
        if ($popupArticle) {
            $this->encryptArticle($popupArticle);
        }

        $this->trackVisit(request());

        return view('home', compact(
            'articles',
            'successStory',
            'videoArticles',
            'categories',
            'categoryArticles',
            'stats',
            'popupArticle'
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

        return view('articles.show', compact(
            'article',
            'related',
            'prevArticle',
            'nextArticle'
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

        return view('categories.articles', compact(
            'category',
            'articles',
            'categories'
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

        return view('pages.learn-more', compact('featuredArticles'));
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
        return view('pages.privacy-policy');
    }

    public function terms()
    {
        return view('pages.terms-of-service');
    }

    public function details()
    {
        $featuredArticles = Article::with(['category', 'image'])
            ->published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get()
            ->map(fn($a) => $this->encryptArticle($a));

        $settings = $this->getSiteSettings();

        return view('pages.details', compact('featuredArticles', 'settings'));
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
            $ua = $request->userAgent() ?? '';
            SiteVisit::create([
                'ip_address'  => $request->ip(),
                'user_agent'  => $ua,
                'device_type' => $this->detectDevice($ua),
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
}
