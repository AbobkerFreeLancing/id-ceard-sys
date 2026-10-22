<?php

namespace App\Filament\Resources\University\FeeStructures\Pages;

use App\Filament\Resources\University\FeeStructures\FeeStructureResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFeeStructures extends ListRecords
{
    protected static string $resource = FeeStructureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
