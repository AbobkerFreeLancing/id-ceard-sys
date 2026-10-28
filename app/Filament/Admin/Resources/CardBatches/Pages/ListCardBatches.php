<?php

namespace App\Filament\Admin\Resources\CardBatches\Pages;

use App\Filament\Admin\Resources\CardBatches\CardBatchResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCardBatches extends ListRecords
{
    protected static string $resource = CardBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
