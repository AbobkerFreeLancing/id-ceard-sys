<?php

namespace App\Filament\Resources\University\FeeStructures\Pages;

use App\Filament\Resources\University\FeeStructures\FeeStructureResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFeeStructure extends EditRecord
{
    protected static string $resource = FeeStructureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            ViewAction::make(),
        ];
    }
}
