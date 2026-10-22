<?php

namespace App\Filament\Resources\University\FeeStructures\Pages;

use App\Filament\Resources\University\FeeStructures\FeeStructureResource;
use Filament\Resources\Pages\ViewRecord;

class ViewFeeStructure extends ViewRecord
{
    protected static string $resource = FeeStructureResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
