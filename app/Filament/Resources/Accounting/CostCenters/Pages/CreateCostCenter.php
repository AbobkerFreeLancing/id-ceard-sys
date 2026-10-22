<?php

namespace App\Filament\Resources\Accounting\CostCenters\Pages;

use App\Filament\Resources\Accounting\CostCenters\CostCenterResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCostCenter extends CreateRecord
{
    protected static string $resource = CostCenterResource::class;

    public function canCreateAnother(): bool
    {
        return false;
    }
}
