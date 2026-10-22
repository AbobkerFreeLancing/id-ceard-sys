<?php

namespace App\Filament\Resources\University\Payments\Pages;

use App\Filament\Resources\University\Payments\PaymentResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            ViewAction::make(),
        ];
    }
}
