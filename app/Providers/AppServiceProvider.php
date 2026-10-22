<?php

namespace App\Providers;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\DevCommands;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        DevCommands::except('vite', 'server');
    }

    public function boot()
    {
        // ON VPS
        // Livewire::setUpdateRoute(function ($handle) {
        //     return Route::post('/admin/livewire/update', $handle);
        // });

        Broadcast::routes(['prefix' => 'api/v1', 'middleware' => ['auth:sanctum']]);

        // Relation::enforceMorphMap([
        //     'user' => 'App\Models\User',
        //     'wallet' => 'Packages\Wallet\Models\Wallet',
        // ]);

        Blade::component('layouts.frontend', 'frontend-layout');

        Fieldset::configureUsing(fn(Fieldset $fieldset) => $fieldset->columnSpanFull());

        Toggle::configureUsing(fn(Toggle $column) => $column->onColor('success')->offColor('gray'));

        ToggleColumn::configureUsing(fn(ToggleColumn $column) => $column->onColor('success')->offColor('gray'));

        Grid::configureUsing(fn(Grid $grid) => $grid->columnSpanFull());

        Section::configureUsing(fn(Section $section) => $section->columnSpanFull());

        Table::configureUsing(function (Table $table): void {
            $table
                ->recordUrl(fn() => null)
                ->defaultSort('created_at', 'desc')
                ->striped()
                ->paginationPageOptions([25, 35, 50])
                ->emptyStateHeading(__('backend.no_records_yet'))
                ->emptyStateIcon('heroicon-o-bookmark')
                ->deferFilters(false)
                ->filtersTriggerAction(fn(Action $action) => $action->button()->label(__('backend.filters')));
        });
    }
}
