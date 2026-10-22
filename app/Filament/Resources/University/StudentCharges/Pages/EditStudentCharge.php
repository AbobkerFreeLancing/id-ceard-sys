<?php

namespace App\Filament\Resources\University\StudentCharges\Pages;

use App\Filament\Resources\University\StudentCharges\StudentChargeResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditStudentCharge extends EditRecord
{
    protected static string $resource = StudentChargeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            ViewAction::make(),
        ];
    }
}
