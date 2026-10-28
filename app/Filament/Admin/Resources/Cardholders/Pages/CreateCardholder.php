<?php

namespace App\Filament\Admin\Resources\Cardholders\Pages;

use App\Filament\Admin\Resources\Cardholders\CardholderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCardholder extends CreateRecord
{
    protected static string $resource = CardholderResource::class;
}
