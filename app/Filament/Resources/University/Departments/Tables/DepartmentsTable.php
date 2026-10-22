<?php

namespace App\Filament\Resources\University\Departments\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DepartmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                TextColumn::make('name_en')->label(__('backend.name_en')),
                TextColumn::make('code')->label(__('backend.code')),
                TextColumn::make('college.name')->label(__('backend.college')),
                ToggleColumn::make('is_active')->label(__('backend.is_active')),
                TextColumn::make('created_at')
                    ->label(__('backend.created_at'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('college_id')
                    ->label(__('backend.college'))
                    ->relationship('college', 'name')
                    ->preload()
                    ->searchable(),
            ])
            ->recordActions([
                //
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                ActionGroup::make([]),
            ])
            ->toolbarActions([
                //
                BulkActionGroup::make([]),
            ]);
    }
}
