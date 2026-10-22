<?php

namespace App\Filament\Resources\University\BatchTransitions\Pages;

use App\Filament\Resources\University\BatchTransitions\BatchTransitionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBatchTransitions extends ListRecords
{
    protected static string $resource = BatchTransitionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
