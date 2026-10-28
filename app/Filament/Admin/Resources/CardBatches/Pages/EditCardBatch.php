<?php

namespace App\Filament\Admin\Resources\CardBatches\Pages;

use App\Filament\Admin\Resources\CardBatches\CardBatchResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditCardBatch extends EditRecord
{
    protected static string $resource = CardBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
