<?php

namespace Packages\Accounting;

use Illuminate\Support\ServiceProvider;

class AccountingServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
       $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
       $this->loadViewsFrom(__DIR__ . '/views', 'bedaya:accounting');
    }
}
