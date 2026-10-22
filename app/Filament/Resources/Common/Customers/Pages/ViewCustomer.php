<?php

namespace App\Filament\Resources\Common\Customers\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Common\Customers\CustomerResource;
use App\Filament\Resources\Common\Customers\RelationManagers\CustomerSalesRelationManager;

class ViewCustomer extends ViewRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function getRelationManagers(): array
    {
        return [
            CustomerSalesRelationManager::class
        ];
    }
}
