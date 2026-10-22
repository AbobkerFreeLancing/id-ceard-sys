<?php

namespace App\Filament\Resources\University\Levels\Pages;

use App\Filament\Resources\University\Levels\LevelResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLevel extends ViewRecord
{
    protected static string $resource = LevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
