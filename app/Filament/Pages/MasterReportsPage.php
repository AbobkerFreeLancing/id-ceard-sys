<?php

namespace App\Filament\Pages;

use App\Filament\Reports\Widgets\AdmissionsReportWidget;
use App\Filament\Reports\Widgets\GradeFeeStructureWidget;
use App\Filament\Reports\Widgets\TopCustomersWidget;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class MasterReportsPage extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = Heroicon::OutlinedDocumentText;

    // protected string $view = 'filament.pages.master-reports-page';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getHeading(): string
    {
        return __('backend.reports');
    }

    public function getTitle(): string
    {
        return __('backend.reports');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__("backend.reports"));
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 12;
    }

    public function getHeaderWidgets(): array
    {
        return [
            GradeFeeStructureWidget::class,
            AdmissionsReportWidget::class,
            TopCustomersWidget::class,
        ];
    }
}
