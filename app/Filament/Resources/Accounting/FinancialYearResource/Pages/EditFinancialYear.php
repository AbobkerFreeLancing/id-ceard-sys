<?php

namespace App\Filament\Resources\Accounting\FinancialYearResource\Pages;

use App\Filament\Resources\Accounting\FinancialYearResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFinancialYear extends EditRecord
{
    protected static string $resource = FinancialYearResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
