<?php

namespace App\Filament\Resources\University\Courses\Pages;

use App\Filament\Resources\University\Courses\CourseResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCourse extends EditRecord
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            ViewAction::make(),
        ];
    }
}
