<?php

namespace App\Filament\Resources\FrontPages\HomeResource\Pages;

use App\Filament\Resources\FrontPages\HomeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHome extends CreateRecord
{
    protected static string $resource = HomeResource::class;
}
