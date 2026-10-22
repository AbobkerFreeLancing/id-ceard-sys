<?php

namespace App\Filament\Resources\Accounting\Transactions\Pages;

use App\Filament\Resources\Accounting\Transactions\TransactionResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
            ->color('gray'),
        ];
    }
}
