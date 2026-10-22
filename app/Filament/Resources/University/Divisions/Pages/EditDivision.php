<?php

namespace App\Filament\Resources\University\Divisions\Pages;

use App\Filament\Resources\University\Divisions\DivisionResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDivision extends EditRecord
{
    protected static string $resource = DivisionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            ViewAction::make(),
        ];
    }
}
