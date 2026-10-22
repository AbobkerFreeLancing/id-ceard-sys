<?php

namespace App\Filament\Resources\University\CourseAllocations\Pages;

use App\Filament\Resources\University\CourseAllocations\CourseAllocationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCourseAllocation extends ViewRecord
{
    protected static string $resource = CourseAllocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
