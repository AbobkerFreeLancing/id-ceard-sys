<?php

namespace App\Filament\Resources\Support\TicketCategories\Pages;

use App\Filament\Resources\Support\TicketCategories\TicketCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTicketCategories extends ManageRecords
{
    protected static string $resource = TicketCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            CreateAction::make()->createAnother(false)->modalWidth('lg'),
        ];
    }
}
