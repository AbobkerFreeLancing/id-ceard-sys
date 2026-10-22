<?php

namespace App\Filament\Resources\University\Batches\Tables;

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

class BatchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                TextColumn::make('code')->label(__('backend.code')),
                TextColumn::make('academicYear.name')->label(__('backend.academic_year')),
                TextColumn::make('college.name')->label(__('backend.college')),
                TextColumn::make('department.name')->label(__('backend.department')),
                ToggleColumn::make('is_active')->label(__('backend.is_active')),
                TextColumn::make('created_at')
                    ->label(__('backend.created_at'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('academic_year_id')
                    ->label(__('backend.academic_year'))
                    ->relationship('academicYear', 'name')
                    ->preload()
                    ->searchable(),
                SelectFilter::make('college_id')
                    ->label(__('backend.college'))
                    ->relationship('college', 'name')
                    ->preload()
                    ->searchable(),
                SelectFilter::make('department_id')
                    ->label(__('backend.department'))
                    ->relationship('department', 'name')
                    ->preload()
                    ->searchable(),
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                ActionGroup::make([
                    //
                    DeleteAction::make()->disabled(fn($record) => $record->has('students')),
                ]),
            ])
            ->toolbarActions([BulkActionGroup::make([])]);
    }
}
