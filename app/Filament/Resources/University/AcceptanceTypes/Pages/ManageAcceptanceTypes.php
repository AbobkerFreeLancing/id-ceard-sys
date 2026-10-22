<?php

namespace App\Filament\Resources\University\AcceptanceTypes\Pages;

use App\Filament\Resources\University\AcceptanceTypes\AcceptanceTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAcceptanceTypes extends ManageRecords
{
    protected static string $resource = AcceptanceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
