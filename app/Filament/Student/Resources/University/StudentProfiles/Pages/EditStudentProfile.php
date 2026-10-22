<?php

namespace App\Filament\Student\Resources\University\StudentProfiles\Pages;

use App\Filament\Student\Resources\University\StudentProfiles\StudentProfileResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditStudentProfile extends EditRecord
{
    protected static string $resource = StudentProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            ViewAction::make(),
        ];
    }
}
