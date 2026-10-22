<?php

namespace App\Filament\Resources\Accounting\AccountBalanceTransferResource\Pages;

use App\Filament\Resources\Accounting\AccountBalanceTransferResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewAccountBalanceTransfer extends ViewRecord
{
    protected static string $resource = AccountBalanceTransferResource::class;
    protected string $view = 'filament.resources.view-account-balance-transfer';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')->label(__('backend.print'))
            ->color('warning')->icon('heroicon-o-printer')
            ->action(function () {
                $this->js("window.print()");
            }),
        ];
    }
}
