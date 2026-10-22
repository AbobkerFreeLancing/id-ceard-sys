<?php

namespace App\Filament\Resources\Accounting\Taxes\Pages;

use App\Filament\Resources\Accounting\Taxes\TaxResource;
use Filament\Resources\Pages\EditRecord;

class EditTax extends EditRecord
{
    protected static string $resource = TaxResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
