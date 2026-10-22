<?php

namespace App\Filament\Resources\University\Colleges\Pages;

use App\Filament\Resources\University\Colleges\CollegeResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCollege extends EditRecord
{
    protected static string $resource = CollegeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            ViewAction::make(),
        ];
    }
}
