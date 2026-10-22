<?php

namespace App\Filament\Resources\Accounting\AccountResource\Pages;

use App\Filament\Resources\Accounting\AccountResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAccount extends CreateRecord
{
    protected static string $resource = AccountResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $parent_acc = $this->record->parent;
        $this->record->code = $parent_acc->code . ($parent_acc->children()->count() + 1);
        $this->record->save();
    }
}
