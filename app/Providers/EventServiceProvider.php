<?php

namespace App\Providers;

use App\Models\Sponsor;
use App\Models\Category;
use App\Models\Article;
use App\Models\Family;
use App\Models\SponsoredChild;
use App\Models\DonationProject;
use App\Observers\AdminActivityObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Sponsor::observe(AdminActivityObserver::class);
        Category::observe(AdminActivityObserver::class);
        Article::observe(AdminActivityObserver::class);
        Family::observe(AdminActivityObserver::class);
        SponsoredChild::observe(AdminActivityObserver::class);
        DonationProject::observe(AdminActivityObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
