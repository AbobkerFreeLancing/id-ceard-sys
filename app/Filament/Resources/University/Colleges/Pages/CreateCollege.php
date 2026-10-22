<?php

namespace App\Filament\Resources\University\Colleges\Pages;

use App\Filament\Resources\University\Colleges\CollegeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCollege extends CreateRecord
{
    protected static string $resource = CollegeResource::class;

    public function canCreateAnother(): bool
    {
        return false;
    }
}
