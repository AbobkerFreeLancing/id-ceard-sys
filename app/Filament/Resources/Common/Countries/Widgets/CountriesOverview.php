<?php

namespace App\Filament\Resources\Common\Countries\Widgets;

use Packages\Common\Models\Country;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountriesOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(label: __('backend.enabled'), value: Country::enabled()->count())
                ->icon(Heroicon::OutlinedGlobeAlt)
                ->chart([7, 2, 10, 3, 5, 4, 17])
                ->color(Color::Green),
            Stat::make(label: __('backend.disabled'), value: Country::disabled()->count())
                ->icon(Heroicon::OutlinedGlobeAlt)
                ->chart([7, 2, 10, 3, 5, 4, 17])
                ->color(Color::Red),
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return [
            'default' => 2,
            'lg' => 2,
        ];
    }

    protected function getColumns(): int|array|null
    {
        return [
            'default' => 2,
            'lg' => 2,
        ];
    }
}
