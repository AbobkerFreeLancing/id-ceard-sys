<?php

namespace App\Filament\Resources\University\InstallmentPlans\Pages;

use App\Filament\Resources\University\InstallmentPlans\InstallmentPlanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInstallmentPlan extends ViewRecord
{
    protected static string $resource = InstallmentPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
