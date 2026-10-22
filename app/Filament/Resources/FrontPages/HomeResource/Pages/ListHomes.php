<?php

namespace App\Filament\Resources\FrontPages\HomeResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\FrontPages\HomeResource;
use App\Models\HomePage;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomes extends ListRecords
{
    protected static string $resource = HomeResource::class;

    public function mount(): void
    {
        $this->redirect($this->getResource()::getUrl('edit',[HomePage::first()->id]));
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
