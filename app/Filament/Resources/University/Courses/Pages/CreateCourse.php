<?php

namespace App\Filament\Resources\University\Courses\Pages;

use App\Filament\Resources\University\Courses\CourseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;
}
