<?php

namespace App\Filament\Resources\University\StudentUniversityIDCards\Pages;

use App\Filament\Resources\University\StudentUniversityIDCards\StudentUniversityIDCardResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditStudentUniversityIDCard extends EditRecord
{
    protected static string $resource = StudentUniversityIDCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            ViewAction::make(),
        ];
    }
}
