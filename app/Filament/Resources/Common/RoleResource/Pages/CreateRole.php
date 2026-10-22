<?php

namespace App\Filament\Resources\Common\RoleResource\Pages;

use App\Filament\Resources\Common\RoleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    public function canCreateAnother(): bool
    {
        return false;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = 'role_' . random_int(100, 999) . rand(22,55);
        return $data;
    }
}
