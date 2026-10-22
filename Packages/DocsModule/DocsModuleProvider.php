<?php

namespace Packages\DocsModule;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class DocsModuleProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        Livewire::addNamespace(
            namespace: 'bedaya:docs',
            classNamespace: 'Packages\\DocsModule\\Livewire',
            classPath: __DIR__ . '/Livewire',
            classViewPath: __DIR__ . '/../resources/views/livewire',
        );

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/views', 'bedaya:docs');
    }
}
