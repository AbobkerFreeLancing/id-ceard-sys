<?php

namespace App\Filament\Resources\Common\Devs\Pages;

use App\Filament\Resources\Common\Devs\DevResource;
use Filament\Resources\Pages\EditRecord;

class EditDev extends EditRecord
{
    protected static string $resource = DevResource::class;

    public function getTitle(): string
    {
        return 'Dev';
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
