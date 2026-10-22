<?php

namespace App\Filament\Resources\University\Courses\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order', 'ASC')
            ->columns([
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                TextColumn::make('name_en')->label(__('backend.name_en')),
                TextColumn::make('credit_hours')->label(__('backend.credit_hours')),
                TextColumn::make('sort_order')->label(__('backend.sort_order')),
                TextColumn::make('created_at')
                    ->label(__('backend.created_at'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                ActionGroup::make([
                    //
                    DeleteAction::make()->hidden(),
                ]),
            ])
            ->toolbarActions([BulkActionGroup::make([])]);
    }
}
