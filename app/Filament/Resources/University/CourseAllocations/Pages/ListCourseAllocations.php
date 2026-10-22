<?php

namespace App\Filament\Resources\University\CourseAllocations\Pages;

use App\Filament\Resources\University\CourseAllocations\CourseAllocationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCourseAllocations extends ListRecords
{
    protected static string $resource = CourseAllocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
