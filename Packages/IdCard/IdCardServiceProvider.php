<?php

namespace Packages\IdCard;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

class IdCardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/idcard.php', 'idcard');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // 1. Migrations
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');

        // 2. Views & Namespaces
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'idcard');

        // 3. Translations
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'idcard');

        // 4. Livewire Components Namespace Registration
        Livewire::addNamespace(
            namespace: 'idcard',
            classNamespace: 'Packages\\IdCard\\Livewire',
            classPath: __DIR__ . '/Livewire',
            classViewPath: __DIR__ . '/resources/views/livewire',
        );

        // 5. Package Routes
        $this->registerRoutes();
    }

    /**
     * Register package routes.
     */
    protected function registerRoutes(): void
    {
        // Web Routes (Verification portal, card previews)
        Route::middleware('web')
            ->group(__DIR__ . '/routes/web.php');

        // API Routes (Hardware scanners, mobile scanners)
        Route::prefix('api/idcard')
            ->middleware('api')
            ->group(__DIR__ . '/routes/api.php');
    }
}
