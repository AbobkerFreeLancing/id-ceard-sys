<?php

namespace Packages\University;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class UniversityServiceProvider extends ServiceProvider
{
    public function register() {}

    public function boot()
    {
        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');

        // Views
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'university');

        // Translations
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'university');

        // Config
        $this->mergeConfigFrom(__DIR__ . '/config/university.php', 'university');

        // Register Package Routes
        $this->registerPackageRoutes();
    }

    /**
     * Register the package routes with prefixes and middleware.
     */
    protected function registerPackageRoutes(): void
    {
        // 1. API v1 Routes (Prefix: api/v1/...)
        Route::prefix('api/v1')
            ->middleware('api')
            ->group(__DIR__ . '/routes/api.php');

        // 2. API v2 Routes (Prefix: api/v2/...)
        Route::prefix('api/v2')
            ->middleware('api')
            ->group(__DIR__ . '/routes/api-v2.php');

        // 3. Web Routes
        Route::middleware('web')->group(__DIR__ . '/routes/web.php');
    }
}
