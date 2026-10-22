<?php

namespace App\Filament\Resources\Common\Fees\Pages;

use App\Filament\Resources\Common\Fees\FeeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageFees extends ManageRecords
{
    protected static string $resource = FeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->createAnother(false)->modalWidth('2xl'),
        ];
    }
}
