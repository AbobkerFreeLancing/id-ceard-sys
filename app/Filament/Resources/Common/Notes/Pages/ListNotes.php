<?php

namespace App\Filament\Resources\Common\Notes\Pages;

use App\Filament\Resources\Common\Notes\NoteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListNotes extends ListRecords
{
    protected static string $resource = NoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->modalWidth(Width::Medium),
        ];
    }
}
