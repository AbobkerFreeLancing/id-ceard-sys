<?php

namespace App\Filament\Resources\Accounting\PaymentMethodResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Accounting\PaymentMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaymentMethods extends ListRecords
{
    protected static string $resource = PaymentMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
