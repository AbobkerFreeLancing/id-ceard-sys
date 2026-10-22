<?php

namespace App\Filament\Resources\Accounting\ReceiptVouchers\Pages;

use App\Filament\Resources\Accounting\ReceiptVouchers\ReceiptVoucherResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditReceiptVoucher extends EditRecord
{
    protected static string $resource = ReceiptVoucherResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
