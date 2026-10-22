<?php

namespace App\Filament\Resources\University\CourseAllocations\Tables;

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

class CourseAllocationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course.name')->label(__('backend.course')),
                TextColumn::make('department.name')->label(__('backend.department')),
                TextColumn::make('academicYear.name')->label(__('backend.academic_year')),
                TextColumn::make('semester.name')->label(__('backend.semester')),
                TextColumn::make('state.name')->label(__('backend.state')),
                TextColumn::make('created_at')
                    ->label(__('backend.created_at'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('course_id')
                    ->label(__('backend.course'))
                    ->relationship('course', 'name')
                    ->preload()
                    ->searchable(),
                SelectFilter::make('state_id')
                    ->label(__('backend.state'))
                    ->relationship('state', 'name')
                    ->preload()
                    ->searchable(),
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                ActionGroup::make([DeleteAction::make()]),
            ])
            ->toolbarActions([BulkActionGroup::make([])]);
    }
}
