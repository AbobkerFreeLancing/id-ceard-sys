<?php

namespace App\Filament\Resources\University\Colleges\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Packages\University\Enums\CollegeProgramTypeEnum;

class CollegesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                TextColumn::make('program_type')
                    ->formatStateUsing(fn($state) => $state->getLabel())
                    ->label(__('backend.program_type')),
                TextColumn::make('name_en')->label(__('backend.name_en')),
                TextColumn::make('code')->label(__('backend.code')),
                ToggleColumn::make('is_active')->label(__('backend.is_active')),
                TextColumn::make('created_at')
                    ->label(__('backend.created_at'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                SelectFilter::make('program_type')
                    ->label(__('backend.program_type'))
                    ->options(CollegeProgramTypeEnum::getOptions()),
            ])
            ->recordActions([
                //
                ViewAction::make()->hidden()->iconButton(),
                EditAction::make()->iconButton(),
                ActionGroup::make([]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
