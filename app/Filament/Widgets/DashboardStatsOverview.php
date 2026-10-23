<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Packages\Common\Models\Customer;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use Packages\IdCard\Models\Card;
use Packages\IdCard\Models\Cardholder;
use Packages\IdCard\Models\Department;
use Packages\IdCard\Models\VerificationLog;

class DashboardStatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 0;

    protected ?string $pollingInterval = '10s';

    public static function canView(): bool
    {
        return true;
    }

    protected function getHeading(): ?string
    {
        return ucfirst(__('backend.reports_and_numbers'));
    }

    protected function getDescription(): ?string
    {
        return __('backend.based_on_time_period');
    }

    public function getColumnSpan(): int|string|array
    {
        return [
            'default' => 12,
            'lg' => 12,
        ];
    }

    protected function getColumns(): int|array|null
    {
        return [
            'default' => 1,
            'lg' => 4,
        ];
    }

    public function getStats(): array
    {
        $startDate = $this->pageFilters['startDate'] ?? null;
        $endDate = $this->pageFilters['endDate'] ?? null;

        return [
            Stat::make(
                label: __('backend.cards'),
                value: Card::query()
                    ->when($startDate, fn(Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                    ->count(),
            )
                ->icon(Heroicon::OutlinedIdentification)
                ->chart([3, 6, 9, 14, 18, 24, 30])
                ->color(Color::Blue)
                ->visible(true),

            Stat::make(
                label: __('backend.cardholders'),
                value: Cardholder::query()
                    ->when($startDate, fn(Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                    ->count(),
            )
                ->icon(Heroicon::OutlinedUserGroup)
                ->chart([5, 8, 12, 15, 20, 22, 28])
                ->color(Color::Emerald)
                ->visible(true),

            Stat::make(
                label: __('backend.departments'),
                value: Department::query()
                    ->when($startDate, fn(Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                    ->count(),
            )
                ->icon(Heroicon::OutlinedBuildingOffice)
                ->chart([2, 3, 4, 4, 5, 5, 6])
                ->color(Color::Amber)
                ->visible(true),

            Stat::make(
                label: __('backend.verification_logs'),
                value: VerificationLog::query()
                    ->when($startDate, fn(Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                    ->count(),
            )
                ->icon(Heroicon::OutlinedShieldCheck)
                ->chart([1, 4, 8, 12, 19, 25, 35])
                ->color(Color::Cyan)
                ->visible(true),
        ];
    }
}
