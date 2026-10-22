<?php

namespace App\Filament\Resources\Common\Contracts\Pages;

use App\Filament\Resources\Common\Contracts\ContractResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditContract extends EditRecord
{
    protected static string $resource = ContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }
}
