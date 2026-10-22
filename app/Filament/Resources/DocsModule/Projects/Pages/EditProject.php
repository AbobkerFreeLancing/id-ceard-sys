<?php

namespace App\Filament\Resources\DocsModule\Projects\Pages;

use App\Filament\Resources\DocsModule\Projects\ProjectResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }
}
