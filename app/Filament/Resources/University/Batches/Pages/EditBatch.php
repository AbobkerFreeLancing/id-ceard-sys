<?php

namespace App\Filament\Resources\University\Batches\Pages;

use App\Filament\Resources\University\Batches\BatchResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBatch extends EditRecord
{
    protected static string $resource = BatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            ViewAction::make(),
        ];
    }
}
