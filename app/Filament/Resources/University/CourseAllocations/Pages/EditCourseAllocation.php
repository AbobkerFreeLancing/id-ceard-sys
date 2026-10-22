<?php

namespace App\Filament\Resources\University\CourseAllocations\Pages;

use App\Filament\Resources\University\CourseAllocations\CourseAllocationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCourseAllocation extends EditRecord
{
    protected static string $resource = CourseAllocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
