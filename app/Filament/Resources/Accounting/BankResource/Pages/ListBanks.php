<?php

namespace App\Filament\Resources\Accounting\BankResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Accounting\BankResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBanks extends ListRecords
{
    protected static string $resource = BankResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->modalWidth('lg')];
    }
}
