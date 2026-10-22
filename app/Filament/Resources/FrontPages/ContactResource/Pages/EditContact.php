<?php

namespace App\Filament\Resources\FrontPages\ContactResource\Pages;

use App\Filament\Resources\FrontPages\ContactResource;
use Filament\Resources\Pages\EditRecord;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
