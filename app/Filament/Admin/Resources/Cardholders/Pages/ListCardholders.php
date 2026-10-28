<?php

namespace App\Filament\Admin\Resources\Cardholders\Pages;

use App\Filament\Admin\Resources\Cardholders\CardholderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCardholders extends ListRecords
{
    protected static string $resource = CardholderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
