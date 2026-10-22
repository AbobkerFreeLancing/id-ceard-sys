<?php

namespace App\Filament\Resources\Accounting\FinancialYearResource\Pages;

use App\Filament\Resources\Accounting\FinancialYearResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFinancialYear extends CreateRecord
{
    protected static string $resource = FinancialYearResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function canCreateAnother(): bool
    {
        return false;
    }
}
