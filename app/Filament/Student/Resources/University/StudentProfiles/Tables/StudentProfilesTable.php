<?php

namespace App\Filament\Student\Resources\University\StudentProfiles\Tables;

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

class StudentProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
                    ->columns([
                        TextColumn::make('name')->label(__('backend.name'))->searchable(),
                        //TextColumn::make('name_en')->label(__('backend.name_en')),
                        // ToggleColumn::make('is_active')->label(__('backend.is_active')),
                        // TextColumn::make('plurs_count')->counts('plurs')->label(__('backend.plurs')),
                        // TextColumn::make('xxx.name')->label(__('backend.xxx')),
                        TextColumn::make('created_at')
                        ->label(__('backend.created_at'))
                        ->date()
                        ->toggleable(isToggledHiddenByDefault: true),
                    ])
                    ->filters([
                        // SelectFilter::make('xxx_id')
                        //     ->label(__('backend.xxx'))
                        //     ->relationship('xxx', 'name')
                        //     ->preload()
                        //     ->searchable(),
                    ])
                    ->recordActions([
                        ViewAction::make()->iconButton(),
                        EditAction::make()->iconButton(),
                        ActionGroup::make([
                            DeleteAction::make()
                        ])
                    ])
                    ->toolbarActions([
                        BulkActionGroup::make([]),
                    ]);
    }
}
