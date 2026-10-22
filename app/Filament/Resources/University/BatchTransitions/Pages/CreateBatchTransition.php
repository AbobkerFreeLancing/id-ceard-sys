<?php

namespace App\Filament\Resources\University\BatchTransitions\Pages;

use App\Filament\Resources\University\BatchTransitions\BatchTransitionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBatchTransition extends CreateRecord
{
    protected static string $resource = BatchTransitionResource::class;

    public function canCreateAnother(): bool
    {
        return false;
    }
}
