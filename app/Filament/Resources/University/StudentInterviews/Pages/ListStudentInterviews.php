<?php

namespace App\Filament\Resources\University\StudentInterviews\Pages;

use App\Filament\Resources\University\StudentInterviews\StudentInterviewResource;
use App\Filament\Resources\University\StudentInterviews\Widgets\StudentInterviewStatsOverview;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Packages\University\Enums\StudentInterviewStatusEnum;
use Packages\University\Models\StudentInterview;

class ListStudentInterviews extends ListRecords
{
    protected static string $resource = StudentInterviewResource::class;

    public function getTabs(): array
    {
        return [
            null => Tab::make(__('backend.view_all'))
                ->badge(StudentInterview::count()),

            __('backend.in_waiting') => Tab::make()
                ->query(fn($query) => $query->where('status', StudentInterviewStatusEnum::Pending->value))
                ->badge(StudentInterview::where('status', StudentInterviewStatusEnum::Pending->value)->count())
                ->badgeColor('warning'),

            __('backend.passed') => Tab::make()
                ->query(fn($query) => $query->where('status', StudentInterviewStatusEnum::Passed->value))
                ->badge(StudentInterview::where('status', StudentInterviewStatusEnum::Passed->value)->count())
                ->badgeColor('success'),

            __('backend.rejected') => Tab::make()
                ->query(fn($query) => $query->where('status', StudentInterviewStatusEnum::Rejected->value))
                ->badge(StudentInterview::where('status', StudentInterviewStatusEnum::Rejected->value)->count())
                ->badgeColor('danger'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // StudentInterviewStatsOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
