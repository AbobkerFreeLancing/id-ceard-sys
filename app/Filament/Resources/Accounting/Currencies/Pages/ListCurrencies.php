<?php

namespace App\Filament\Resources\Accounting\Currencies\Pages;

use App\Filament\Resources\Accounting\Currencies\CurrencyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListCurrencies extends ListRecords
{
    protected static string $resource = CurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->modalWidth(Width::Large)
            ->createAnother(false),
        ];
    }
}
