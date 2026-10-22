<?php

namespace App\Filament\Resources\Accounting\JournalResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Accounting\JournalResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJournals extends ListRecords
{
    protected static string $resource = JournalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
