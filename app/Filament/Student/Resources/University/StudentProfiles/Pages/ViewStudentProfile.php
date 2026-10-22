<?php

namespace App\Filament\Student\Resources\University\StudentProfiles\Pages;

use App\Filament\Student\Resources\University\StudentProfiles\StudentProfileResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStudentProfile extends ViewRecord
{
    protected static string $resource = StudentProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
