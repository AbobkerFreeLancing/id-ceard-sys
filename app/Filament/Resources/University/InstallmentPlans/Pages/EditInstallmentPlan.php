<?php

namespace App\Filament\Resources\University\InstallmentPlans\Pages;

use App\Filament\Resources\University\InstallmentPlans\InstallmentPlanResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditInstallmentPlan extends EditRecord
{
    protected static string $resource = InstallmentPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            ViewAction::make(),
        ];
    }
}
