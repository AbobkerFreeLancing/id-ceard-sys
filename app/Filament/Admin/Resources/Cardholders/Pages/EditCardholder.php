<?php

namespace App\Filament\Admin\Resources\Cardholders\Pages;

use App\Filament\Admin\Resources\Cardholders\CardholderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditCardholder extends EditRecord
{
    protected static string $resource = CardholderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
