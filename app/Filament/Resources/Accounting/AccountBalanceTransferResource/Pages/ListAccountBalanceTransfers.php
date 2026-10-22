<?php

namespace App\Filament\Resources\Accounting\AccountBalanceTransferResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Accounting\AccountBalanceTransferResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccountBalanceTransfers extends ListRecords
{
    protected static string $resource = AccountBalanceTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
