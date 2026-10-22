<?php

namespace App\Filament\Resources\University\BatchTransitions\Pages;

use App\Filament\Resources\University\BatchTransitions\BatchTransitionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBatchTransition extends ViewRecord
{
    protected static string $resource = BatchTransitionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
