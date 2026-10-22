<?php

namespace App\Filament\Resources\Accounting\AccountResource\Pages;

use App\Filament\Resources\Accounting\AccountResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListAccounts extends ListRecords
{
    protected static string $resource = AccountResource::class;

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [30, 60, 100];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->modalWidth(Width::Large)
                ->createAnother(false)
                ->after(function ($record) {
                    $parent_acc = $record->parent;
                    $record->code = $parent_acc->code . ($parent_acc->children()->count() + 1);
                    $record->save();
                })
            // Action::make('tree_view')
            // ->color('warning')
            // ->outlined()
            // ->icon('heroicon-o-folder-open')
            // ->label(__('backend.tree_view'))
            // ->url($this->getResource()::getUrl('tree')),
        ];
    }
}
