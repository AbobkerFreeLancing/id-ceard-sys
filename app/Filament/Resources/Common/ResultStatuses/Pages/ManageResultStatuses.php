<?php

namespace App\Filament\Resources\Common\ResultStatuses\Pages;

use App\Filament\Resources\Common\ResultStatuses\ResultStatusResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageResultStatuses extends ManageRecords
{
    protected static string $resource = ResultStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
