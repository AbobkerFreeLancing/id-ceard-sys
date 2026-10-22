<?php

namespace App\Filament\Resources\Common\Contracts\Pages;

use App\Filament\Resources\Common\Contracts\ContractResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContract extends CreateRecord
{
    protected static string $resource = ContractResource::class;

    public function canCreateAnother(): bool
    {
        return false;
    }

    protected function afterCreate(): void
    {
        $this->record->ref_number = 'CT-' . $this->record->id . random_int(100, 999);
        $this->record->save();
    }
}
