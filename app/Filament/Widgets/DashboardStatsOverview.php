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
use Packages\University\Models\College;
use Packages\University\Models\Department;
use Packages\University\Models\Student;

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

        return array_merge([
            Stat::make(
                label: __('backend.students'),
                value: Student::query()
                    ->when($startDate, fn(Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                    ->count(),
            )
                ->icon(Heroicon::OutlinedUserCircle)
                ->chart([7, 5, 10, 6, 4, 5, 11])
                ->color(Color::Blue)
                ->visible(true),
            Stat::make(
                label: __('backend.colleges'),
                value: College::query()
                    ->when($startDate, fn(Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                    ->count(),
            )
                ->icon(Heroicon::OutlinedBuildingOffice2)
                ->chart([7, 5, 10, 6, 4, 5, 11])
                ->color(Color::Amber)
                ->visible(true),
            Stat::make(
                label: __('backend.departments'),
                value: Department::query()
                    ->when($startDate, fn(Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                    ->count(),
            )
                ->icon(Heroicon::OutlinedBuildingOffice)
                ->chart([7, 5, 10, 6, 4, 5, 11])
                ->color(Color::Green)
                ->visible(true),

            Stat::make(
                label: __('backend.users'),
                value: User::where('type', 'user')
                    ->whereDoesntHave('roles', function (Builder $query) {
                        $query->where('name', 'dev');
                    })
                    ->count(),
            )
                ->icon(Heroicon::OutlinedUserCircle)
                ->visible(auth()->user()->can('user_management'))
                ->chart([7, 5, 10, 6, 4, 5, 11])
                ->color(Color::Amber),
        ]);
    }
}
