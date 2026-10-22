<?php

namespace App\Filament\Resources\Accounting\ReceiptVouchers\Pages;

use App\Filament\Resources\Accounting\ReceiptVouchers\ReceiptVoucherResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewReceiptVoucher extends ViewRecord
{
    protected static string $resource = ReceiptVoucherResource::class;
    protected string $view = 'bedaya:accounting::view-receipt-voucher';

    protected function getHeaderActions(): array
    {
        return [
             Action::make('print')
             ->label(__('backend.print'))
             ->color('warning')
             ->icon('heroicon-o-printer')
             ->action(function () {
                $this->js("window.print()");
            }),
        ];
    }
}
