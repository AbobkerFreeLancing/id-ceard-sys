<?php

namespace App\Filament\Resources\University\BatchTransitions\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BatchTransitionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('batch.name')->label(__('backend.batch')),
                TextColumn::make('fromLevel.name')->label(__('backend.from_level')),
                TextColumn::make('toLevel.name')->label(__('backend.to_level')),
                TextColumn::make('academicYear.name')->label(__('backend.academic_year')),
                TextColumn::make('created_at')->label(__('backend.created_at'))->date(),
            ])
            ->filters([
                SelectFilter::make('batch_id')
                    ->label(__('backend.batch'))
                    ->relationship('batch', 'name')
                    ->preload()
                    ->searchable(),
            ])
            ->recordActions([
                //
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                ActionGroup::make([
                    //
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([BulkActionGroup::make([])]);
    }
}
