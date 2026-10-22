<?php

namespace App\Filament\Resources\Accounting\AccountResource\Pages;

use App\Filament\Resources\Accounting\AccountResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccount extends EditRecord
{
    protected static string $resource = AccountResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
