<?php

namespace App\Filament\Student\Resources\University\StudentIdentities\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentIdentitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->where('student_id', student()->id))
            ->columns([
                TextColumn::make('type')->formatStateUsing(fn($state) => $state->getLabel())->label(__('backend.type')),
                ImageColumn::make('attachment')->label(__('backend.attachment')),
                TextColumn::make('created_at')->label(__('backend.added_at')),
                TextColumn::make('notes')->label(__('backend.notes')),
                IconColumn::make('is_approved')->label(__('backend.approved'))->boolean(),
                TextColumn::make('created_at')
                    ->label(__('backend.created_at'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                ViewAction::make()->iconButton()->hidden(),
                EditAction::make()->iconButton()->hidden(),
                ActionGroup::make([
                    //
                    DeleteAction::make()->hidden(fn($record) => $record->is_approved == true),
                ]),
            ])
            ->toolbarActions([BulkActionGroup::make([])]);
    }
}
