<?php

namespace App\Filament\Resources\Accounting\Taxes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class TaxesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('backend.name')),
                TextColumn::make('type_label')->label(__('backend.type')),
                TextColumn::make('amount')->label(__('backend.value')),
                ToggleColumn::make('is_enabled')->label(__('backend.is_enabled')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                ]),
            ]);
    }
}
