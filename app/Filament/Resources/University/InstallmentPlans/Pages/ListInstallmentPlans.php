<?php

namespace App\Filament\Resources\University\InstallmentPlans\Pages;

use App\Filament\Resources\University\InstallmentPlans\InstallmentPlanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInstallmentPlans extends ListRecords
{
    protected static string $resource = InstallmentPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
