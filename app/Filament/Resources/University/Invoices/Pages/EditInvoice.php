<?php

namespace App\Filament\Resources\University\Invoices\Pages;

use App\Filament\Resources\University\Invoices\InvoiceResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            ViewAction::make(),
        ];
    }
}
