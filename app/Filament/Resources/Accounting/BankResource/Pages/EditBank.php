<?php

namespace App\Filament\Resources\Accounting\BankResource\Pages;

use App\Filament\Resources\Accounting\BankResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBank extends EditRecord
{
    protected static string $resource = BankResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
