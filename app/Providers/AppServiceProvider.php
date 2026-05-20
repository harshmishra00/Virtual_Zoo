<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Animal;
use App\Observers\AnimalObserver;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        // Register observer
        Animal::observe(AnimalObserver::class);

        // Helper: conservation badge colour Blade directive
        Blade::directive('badgeColor', function ($status) {
            return "<?php echo \\App\\Helpers\\ZooHelper::badgeColor($status); ?>";
        });
    }
}
