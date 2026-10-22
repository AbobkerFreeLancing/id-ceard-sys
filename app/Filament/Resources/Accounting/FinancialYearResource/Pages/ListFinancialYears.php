<?php

namespace App\Filament\Resources\Accounting\FinancialYearResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Accounting\FinancialYearResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinancialYears extends ListRecords
{
    protected static string $resource = FinancialYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
