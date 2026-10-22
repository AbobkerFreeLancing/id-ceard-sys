<?php

namespace App\Filament\Resources\Common\Branches\Tables;

use Packages\Common\Models\Branch;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class BranchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('name', 'ASC')
            ->columns([
                TextColumn::make('name')->label(__('backend.name')),
                TextColumn::make('slug')->label(__('backend.slug')),
                ToggleColumn::make('is_enabled')
                    ->label(__('backend.enabled'))
                    ->disabled(fn(Branch $record) => $record->is_editable == false),
                TextColumn::make('address')->label(__('backend.address')),
                TextColumn::make('phone')->label(__('backend.phone')),
            ])
            ->filters([])
            ->recordActions([
                // ViewAction::make()->iconButton(),
                EditAction::make()->iconButton()->visible(fn(Branch $record) => $record->is_editable == true),
                ActionGroup::make([DeleteAction::make()->visible(fn(Branch $record) => $record->is_editable == true)]),
            ])
            ->toolbarActions([BulkActionGroup::make([])]);
    }
}
