<?php

namespace App\Filament\Resources\Accounting\Safes\Pages;

use App\Filament\Resources\Accounting\Safes\SafeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSafe extends ViewRecord
{
    protected static string $resource = SafeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
