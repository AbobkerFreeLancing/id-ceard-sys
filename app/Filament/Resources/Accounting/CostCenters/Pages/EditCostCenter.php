<?php

namespace App\Filament\Resources\Accounting\CostCenters\Pages;

use App\Filament\Resources\Accounting\CostCenters\CostCenterResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCostCenter extends EditRecord
{
    protected static string $resource = CostCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }
}
