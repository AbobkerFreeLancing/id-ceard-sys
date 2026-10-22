<?php

namespace App\Filament\Resources\FrontPages\FrontSettingsResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\FrontPages\FrontSettingsResource;
use App\Models\FrontSettings;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFrontSettings extends ListRecords
{
    protected static string $resource = FrontSettingsResource::class;

    public function mount(): void
    {
        $this->redirect($this->getResource()::getUrl('edit',[FrontSettings::first()->id]));
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
