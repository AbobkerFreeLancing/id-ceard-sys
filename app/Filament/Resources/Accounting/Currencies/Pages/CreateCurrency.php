<?php

namespace App\Filament\Resources\Accounting\Currencies\Pages;

use App\Filament\Resources\Accounting\Currencies\CurrencyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCurrency extends CreateRecord
{
    protected static string $resource = CurrencyResource::class;
}
