<?php

namespace App\Filament\Resources\University\MedicalCheckups\Pages;

use App\Filament\Resources\University\MedicalCheckups\MedicalCheckupResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMedicalCheckup extends ViewRecord
{
    protected static string $resource = MedicalCheckupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
