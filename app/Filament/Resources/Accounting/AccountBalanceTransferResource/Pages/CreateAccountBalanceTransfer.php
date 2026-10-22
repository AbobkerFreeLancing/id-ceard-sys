<?php

namespace App\Filament\Resources\Accounting\AccountBalanceTransferResource\Pages;

use App\Filament\Resources\Accounting\AccountBalanceTransferResource;
use App\Models\Setting;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAccountBalanceTransfer extends CreateRecord
{
    protected static string $resource = AccountBalanceTransferResource::class;

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

        // creator
        $this->record->creator_id = auth()->user()->id;
        $this->record->save();

    }
}
