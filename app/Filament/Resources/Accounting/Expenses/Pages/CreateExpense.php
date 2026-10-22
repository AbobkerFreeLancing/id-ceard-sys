<?php

namespace App\Filament\Resources\Accounting\Expenses\Pages;

use App\Filament\Resources\Accounting\Expenses\ExpenseResource;
use App\Models\Setting;
use Filament\Resources\Pages\CreateRecord;

class CreateExpense extends CreateRecord
{
    protected static string $resource = ExpenseResource::class;

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
        $this->record->currency_id = $this->record->payment_account?->currency_id;
        $this->record->save();
    }
}
