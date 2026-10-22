<?php

namespace App\Filament\Pages;

use Packages\Enum\Profile\UserTypeEnum;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Contracts\Support\Htmlable;

class DashboardPage extends BaseDashboard
{
    use HasFiltersForm;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    public function getHeading(): string|Htmlable|null
    {
        return null;
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.home_page');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->type == UserTypeEnum::User->value;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public function getTitle(): string|Htmlable
    {
        return __('backend.home_page');
    }

    public function filtersForm(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()
                ->compact()
                ->schema([
                    DatePicker::make('startDate')->label(__('backend.from_date'))->default(now()->subMonths(3)),
                    DatePicker::make('endDate')->label(__('backend.to_date'))->default(now()),
                ])
                ->columnSpanFull()
                ->columns([
                    'default' => 2,
                    'lg' => 3,
                ]),
        ]);
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         FilterAction::make()
    //             ->schema([
    //                 DatePicker::make('startDate')->label(__('backend.from_date'))->default(now()->subMonths(3)),
    //                 DatePicker::make('endDate')->label(__('backend.to_date'))->default(now()),
    //             ]),
    //     ];
    // }

    public function getWidgets(): array
    {
        $widgets = Filament::getWidgets();

        return array_filter($widgets, function ($widget) {
            return $widget !== AccountWidget::class && $widget !== FilamentInfoWidget::class;
        });
    }

    public function getColumns(): int|array
    {
        return 12;
    }
}
