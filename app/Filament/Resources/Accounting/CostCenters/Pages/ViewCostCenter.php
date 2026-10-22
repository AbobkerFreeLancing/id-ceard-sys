<?php

namespace App\Filament\Resources\Accounting\CostCenters\Pages;

use App\Filament\Resources\Accounting\CostCenters\CostCenterResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCostCenter extends ViewRecord
{
    protected static string $resource = CostCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
