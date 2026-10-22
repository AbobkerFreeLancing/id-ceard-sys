<?php

namespace App\Filament\Resources\Accounting\Safes\Pages;

use App\Filament\Resources\Accounting\Safes\SafeResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSafe extends EditRecord
{
    protected static string $resource = SafeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
