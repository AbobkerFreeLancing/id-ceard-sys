<?php

namespace App\Filament\Resources\Common\StateResource\Pages;

use App\Filament\Resources\Common\StateResource;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditState extends EditRecord
{
    protected static string $resource = StateResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
