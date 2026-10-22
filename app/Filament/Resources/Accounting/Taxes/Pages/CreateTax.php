<?php

namespace App\Filament\Resources\Accounting\Taxes\Pages;

use App\Filament\Resources\Accounting\Taxes\TaxResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTax extends CreateRecord
{
    protected static string $resource = TaxResource::class;

    public function canCreateAnother(): bool
    {
        return false;
    }
}
