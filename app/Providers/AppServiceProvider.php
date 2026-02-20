<?php

namespace App\Providers;
// use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\NumberHelper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         // Format large numbers: @formatNumber(1500) → "1.5K"
        Blade::directive('formatNumber', function ($expression) {
            return "<?php echo \App\Helpers\NumberHelper::formatNumber($expression); ?>";
        });
        
        // Format bytes: @formatBytes(1024000) → "1 MB"
        Blade::directive('formatBytes', function ($expression) {
            return "<?php echo \App\Helpers\NumberHelper::formatBytes($expression); ?>";
        });
        
        // Format duration: @formatDuration(125) → "2m 5s"
        Blade::directive('formatDuration', function ($expression) {
            return "<?php echo \App\Helpers\NumberHelper::formatDuration($expression); ?>";
        });

        //  if (config('app.env') === 'local') {
        //     URL::forceScheme('https');
        // }
    }
}
