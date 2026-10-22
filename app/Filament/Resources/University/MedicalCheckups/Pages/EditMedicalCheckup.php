<?php

namespace App\Filament\Resources\University\MedicalCheckups\Pages;

use App\Filament\Resources\University\MedicalCheckups\MedicalCheckupResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMedicalCheckup extends EditRecord
{
    protected static string $resource = MedicalCheckupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            ViewAction::make(),
        ];
    }
}
