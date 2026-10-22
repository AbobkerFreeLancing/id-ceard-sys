<?php

namespace App\Filament\Resources\Common\Notes\Pages;

use App\Filament\Resources\Common\Notes\NoteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNote extends EditRecord
{
    protected static string $resource = NoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
