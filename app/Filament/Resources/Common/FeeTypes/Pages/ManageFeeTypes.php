<?php

namespace App\Filament\Resources\Common\FeeTypes\Pages;

use App\Filament\Resources\Common\FeeTypes\FeeTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageFeeTypes extends ManageRecords
{
    protected static string $resource = FeeTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->createAnother(false)->modalWidth('2xl'),
        ];
    }
}
