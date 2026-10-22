<?php

namespace App\Filament\Resources\Accounting\ReceiptVouchers\Pages;

use App\Filament\Resources\Accounting\ReceiptVouchers\ReceiptVoucherResource;
use App\Models\Setting;
use Filament\Resources\Pages\CreateRecord;

class CreateReceiptVoucher extends CreateRecord
{
    protected static string $resource = ReceiptVoucherResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function canCreateAnother(): bool
    {
        return false;
    }

    protected function afterCreate(): void
    {
        $this->record->financial_year_id = Setting::find(1)->financial_year_id;
        $this->record->creator_id = auth()->user()->id;
        $this->record->save();
    }
}
