<?php

namespace App\Filament\Resources\FrontPages\FrontSettingsResource\Pages;

use App\Filament\Resources\FrontPages\FrontSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFrontSettings extends EditRecord
{
    protected static string $resource = FrontSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
