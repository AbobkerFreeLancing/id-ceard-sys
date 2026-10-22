<?php

namespace App\Filament\Resources\University\Batches\Pages;

use App\Filament\Resources\University\Batches\BatchResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBatch extends ViewRecord
{
    protected static string $resource = BatchResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
