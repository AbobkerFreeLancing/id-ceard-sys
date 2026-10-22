<?php

namespace App\Filament\Resources\Accounting\CostCenters\Tables;

use Packages\Accounting\Enum\AccountLevelTypeEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CostCentersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('backend.name')),
                TextColumn::make('level_type')
                    ->formatStateUsing(fn($state) => AccountLevelTypeEnum::from($state)->getLabel())
                    ->icon(fn($record) => $record->isGroup() ? 'heroicon-o-folder' : 'heroicon-o-document')
                    ->badge()
                    ->color(fn($record) => $record->isGroup() ? 'success' : 'warning')
                    ->label(__('backend.account_level_type')),
                TextColumn::make('parent.name')
                    ->label(__('backend.parent_account'))
                    ->formatStateUsing(fn($state) => $state != null ? $state : '-'),
            ])
            ->filters([
                //
            ])
            ->recordActions([ViewAction::make()->iconButton(), EditAction::make()->iconButton()])
            ->toolbarActions([BulkActionGroup::make([])]);
    }
}
