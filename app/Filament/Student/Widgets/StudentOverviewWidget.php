<?php

namespace App\Filament\Student\Widgets;

use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;

class StudentOverviewWidget extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected ?string $pollingInterval = '45s';

    public static function canView(): bool
    {
        return true;
    }

    protected function getHeading(): ?string
    {
        return __('backend.welcome') . ' ' . student()->name;
    }

    public function getStats(): array
    {
        $startDate = $this->pageFilters['startDate'] ?? null;
        $endDate = $this->pageFilters['endDate'] ?? null;

        return [
            Stat::make(
                label: __("backend.students"),
                value: 2,
            )->icon(Heroicon::OutlinedUser)
                ->chart([7, 5, 10, 6, 4, 5, 11])
                ->color(Color::Green),

            Stat::make(
                label: __("backend.bookmarks"),
                value: 5,
            )->icon(Heroicon::OutlinedWallet)
                ->chart([7, 5, 10, 6, 4, 5, 11])
                ->color(Color::Blue),
        ];
    }

    public function getColumnSpan(): int | string | array
    {
        return [
            'default' => 12,
            'lg' => 12
        ];
    }

    protected function getColumns(): int | array | null
    {
        return [
            'default' => 1,
            'lg' => 4
        ];
    }
}
