<?php

namespace App\Filament\Resources\University\Departments\Pages;

use App\Filament\Resources\University\Departments\DepartmentResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDepartment extends EditRecord
{
    protected static string $resource = DepartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            ViewAction::make(),
        ];
    }
}
