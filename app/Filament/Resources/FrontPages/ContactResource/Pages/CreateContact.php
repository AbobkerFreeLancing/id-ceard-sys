<?php

namespace App\Filament\Resources\FrontPages\ContactResource\Pages;

use App\Filament\Resources\FrontPages\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;
}
