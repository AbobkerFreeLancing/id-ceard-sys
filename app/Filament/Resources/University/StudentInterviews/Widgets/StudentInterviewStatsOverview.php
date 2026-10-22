<?php

namespace App\Filament\Resources\University\StudentInterviews\Widgets;

use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Packages\University\Enums\StudentInterviewStatusEnum;
use Packages\University\Models\StudentInterview;

class StudentInterviewStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $total = StudentInterview::count();
        $pending = StudentInterview::where('status', StudentInterviewStatusEnum::Pending->value)->count();
        $passed = StudentInterview::where('status', StudentInterviewStatusEnum::Passed->value)->count();
        $rejected = StudentInterview::where('status', StudentInterviewStatusEnum::Rejected->value)->count();
        $evaluated = $passed + $rejected;
        $passRate = $evaluated > 0 ? round(($passed / $evaluated) * 100, 1) : 0;

        return [
            Stat::make(label: __('backend.candidate_students'), value: $total)
                ->icon(Heroicon::OutlinedUserGroup)
                ->color(Color::Blue),

            Stat::make(label: __('backend.pending_students'), value: $pending)
                ->icon(Heroicon::OutlinedClock)
                ->color(Color::Amber),

            Stat::make(label: __('backend.passed_students'), value: $passed)
                ->icon(Heroicon::OutlinedCheckCircle)
                ->color(Color::Green),

            Stat::make(label: __('backend.rejected_students'), value: $rejected)
                ->icon(Heroicon::OutlinedXCircle)
                ->color(Color::Red),
        ];
    }

    protected function getColumns(): int|array|null
    {
        return [
            'default' => 2,
            'md' => 4,
            'lg' => 4,
        ];
    }
}
