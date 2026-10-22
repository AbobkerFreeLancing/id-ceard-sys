<?php

namespace App\Filament\Resources\FrontPages\AboutResource\Pages;

use App\Filament\Resources\FrontPages\AboutResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAbout extends EditRecord
{
    protected static string $resource = AboutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
