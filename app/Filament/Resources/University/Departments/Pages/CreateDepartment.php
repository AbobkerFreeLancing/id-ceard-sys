<?php

namespace App\Filament\Resources\University\Departments\Pages;

use App\Filament\Resources\University\Departments\DepartmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDepartment extends CreateRecord
{
    protected static string $resource = DepartmentResource::class;

    public function canCreateAnother(): bool
    {
        return false;
    }
}
