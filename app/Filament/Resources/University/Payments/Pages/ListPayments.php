<?php

namespace App\Filament\Resources\University\Payments\Pages;

use App\Filament\Resources\University\Payments\PaymentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            CreateAction::make()->hidden(),
        ];
    }
}
