<?php

namespace App\Filament\Resources\University\CourseAllocations\Pages;

use App\Filament\Resources\University\CourseAllocations\CourseAllocationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCourseAllocation extends CreateRecord
{
    protected static string $resource = CourseAllocationResource::class;
}
