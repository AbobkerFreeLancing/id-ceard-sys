<?php

namespace App\Filament\Resources\Common\Notes\Pages;

use App\Filament\Resources\Common\Notes\NoteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNote extends CreateRecord
{
    protected static string $resource = NoteResource::class;
}
