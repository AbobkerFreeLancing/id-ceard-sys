<?php

namespace App\Filament\Resources\University\StudentInterviews\Pages;

use App\Filament\Resources\University\StudentInterviews\StudentInterviewResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStudentInterview extends ViewRecord
{
    protected static string $resource = StudentInterviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
