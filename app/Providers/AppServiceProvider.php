<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Settings;

use App\Observers\LogObserver;

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
        $modelExceptions = ['Log', 'Template', 'PreventPostSpam'];

        foreach (glob(app_path('Models/*.php')) as $modelFile) {
            $baseName = basename($modelFile, '.php');
            $className = 'App\\Models\\' . $baseName;

            if (!in_array($baseName, $modelExceptions) && class_exists($className)) {
                $className::observe(LogObserver::class);
            }
        }

        view()->composer('*', function ($view) {
            $settings = Settings::firstOrNew(); // Fetch settings from the database
            $view->with('settings', $settings);
        });
    }
}
