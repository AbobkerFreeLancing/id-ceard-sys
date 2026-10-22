<?php

namespace App\Filament\Resources\FrontPages\AboutResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\FrontPages\AboutResource;
use App\Models\AboutPage;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAbouts extends ListRecords
{
    protected static string $resource = AboutResource::class;

    public function mount(): void
    {
        $this->redirect($this->getResource()::getUrl('edit',[AboutPage::first()->id]));
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
