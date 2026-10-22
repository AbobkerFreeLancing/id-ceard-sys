<?php

namespace App\Filament\Resources\University\AbsenceTypes\Pages;

use App\Filament\Resources\University\AbsenceTypes\AbsenceTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAbsenceTypes extends ManageRecords
{
    protected static string $resource = AbsenceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->modalWidth('lg')->createAnother(false),
        ];
    }
}
