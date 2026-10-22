<?php

namespace App\Filament\Resources\FrontPages\ContactResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\FrontPages\ContactResource;
use App\Models\ContactPage;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

    public function mount(): void
    {
        $this->redirect($this->getResource()::getUrl('edit',[ContactPage::first()->id]));
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
