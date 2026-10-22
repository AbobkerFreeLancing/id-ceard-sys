<?php

namespace Packages\Providers;

use App\Filament\Commands\FileGenerators\Resources\BedayaFormGenerator;
use App\Filament\Commands\FileGenerators\Resources\BedayaResourceClassGenerator;
use App\Filament\Commands\FileGenerators\Resources\BedayaTableGenerator;
use Filament\Commands\FileGenerators\Resources\ResourceClassGenerator;
use Filament\Commands\FileGenerators\Resources\Schemas\ResourceFormSchemaClassGenerator;
use Filament\Commands\FileGenerators\Resources\Schemas\ResourceTableClassGenerator;
use Illuminate\Support\ServiceProvider;

class BedayaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ResourceClassGenerator::class, BedayaResourceClassGenerator::class);
        $this->app->bind(ResourceFormSchemaClassGenerator::class, BedayaFormGenerator::class);
        $this->app->bind(ResourceTableClassGenerator::class, BedayaTableGenerator::class);

        // Common Module
        $this->app->register(\Packages\Common\CommonServiceProvider::class);

        // Accounting Module
        if (config('bedaya.accounting_enabled')) {
            $this->app->register(\Packages\Accounting\AccountingServiceProvider::class);
        }

        // Support / Tickets Module
        if (config('bedaya.support_tickets_enabled')) {
            $this->app->register(\Packages\Support\SupportServiceProvider::class);
        }

        // Docs Module
        if (config('bedaya.docs_module_enabled')) {
            $this->app->register(\Packages\DocsModule\DocsModuleProvider::class);
        }

        // Chat Module
        if (config('bedaya.chat_enabled')) {
            $this->app->register(\Packages\Chat\ChatServiceProvider::class);
        }

        // university Module
        if (config('bedaya.university_enabled')) {
            $this->app->register(\Packages\University\UniversityServiceProvider::class);
        }
    }
}
