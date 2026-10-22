<?php

namespace App\Filament\Resources\FrontPages\HomeResource\Pages;

use App\Filament\Resources\FrontPages\HomeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHome extends EditRecord
{
    protected static string $resource = HomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
