<?php

namespace App\Filament\Resources\Common\PermissionResource\Pages;

use App\Filament\Resources\Common\PermissionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPermission extends EditRecord
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
