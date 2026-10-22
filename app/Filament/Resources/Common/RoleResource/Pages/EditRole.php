<?php

namespace App\Filament\Resources\Common\RoleResource\Pages;

use App\Filament\Resources\Common\RoleResource;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            $this->getSaveFormAction()
        ];
    }
}
