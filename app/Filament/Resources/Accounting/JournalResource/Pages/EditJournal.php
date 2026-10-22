<?php

namespace App\Filament\Resources\Accounting\JournalResource\Pages;

use App\Filament\Resources\Accounting\JournalResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJournal extends EditRecord
{
    protected static string $resource = JournalResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()->disabled(function () {
                return $this->data['debit_total'] != $this->data['credit_total'];
            }),
            $this->getCancelFormAction(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
