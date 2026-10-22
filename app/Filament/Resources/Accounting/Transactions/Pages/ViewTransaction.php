<?php

namespace App\Filament\Resources\Accounting\Transactions\Pages;

use App\Filament\Resources\Accounting\Transactions\TransactionResource;
use Filament\Resources\Pages\ViewRecord;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;

    public function getTitle(): string
    {
        return __('backend.transaction_details');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
