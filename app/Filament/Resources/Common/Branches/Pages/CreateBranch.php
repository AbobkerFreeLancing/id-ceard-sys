<?php

namespace App\Filament\Resources\Common\Branches\Pages;

use App\Filament\Resources\Common\Branches\BranchResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBranch extends CreateRecord
{
    protected static string $resource = BranchResource::class;

    public function canCreateAnother(): bool
    {
        return false;
    }
}
