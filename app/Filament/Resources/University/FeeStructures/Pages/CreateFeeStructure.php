<?php

namespace App\Filament\Resources\University\FeeStructures\Pages;

use App\Filament\Resources\University\FeeStructures\FeeStructureResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFeeStructure extends CreateRecord
{
    protected static string $resource = FeeStructureResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function canCreateAnother(): bool
    {
        return false;
    }
}
