<?php

namespace App\Filament\Resources\Accounting\JournalResource\Pages;

use App\Filament\Resources\Accounting\JournalResource;
use App\Models\Setting;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJournal extends CreateRecord
{
    protected static string $resource = JournalResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()->disabled(function(){
                return $this->data['debit_total'] != $this->data['credit_total'];
            }),
            $this->getCancelFormAction(),
        ];
    }

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
        $this->record->ref_number = 1000 + $this->record->id;
        $this->record->financial_year_id = Setting::find(1)->financial_year_id;
        $this->record->creator_id = auth()->user()->id;
        $this->record->save();
    }
}
