<?php

namespace App\Filament\Resources\Accounting\AccountBalanceTransferResource\Pages;

use App\Filament\Resources\Accounting\AccountBalanceTransferResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccountBalanceTransfer extends EditRecord
{
    protected static string $resource = AccountBalanceTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
