<?php

namespace App\Filament\Resources\University\BatchTransitions\Pages;

use App\Filament\Resources\University\BatchTransitions\BatchTransitionResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBatchTransition extends EditRecord
{
    protected static string $resource = BatchTransitionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            ViewAction::make(),
        ];
    }
}
