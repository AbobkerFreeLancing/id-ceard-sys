<?php

namespace App\Filament\Resources\University\AcademicYears\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Packages\University\Models\AcademicYear;

class AcademicYearsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('backend.year'))->searchable(),
                IconColumn::make('is_current')->label(__('backend.is_current_year'))->boolean(),
                ToggleColumn::make('is_active')->label(__('backend.is_active')),
                TextColumn::make('start_date')->label(__('backend.start_date')),
                TextColumn::make('end_date')->label(__('backend.end_date')),
                TextColumn::make('created_at')
                    ->label(__('backend.created_at'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                Action::make('make_current')
                    ->label(__('backend.mark_as_current_year'))
                    ->button()
                    ->outlined()
                    ->visible(fn($record) => $record->is_current == false)
                    ->action(function ($record) {
                        $record->update([
                            'is_current' => true,
                        ]);

                        $other = AcademicYear::where('id', '!=', $record->id)->get();

                        if ($other != null) {
                            $other->each(function ($item) {
                                $item->update([
                                    'is_current' => false,
                                ]);
                            });
                        }

                        Notification::make()->title(__('backend.action_updated'))->success()->send();
                    })
                    ->requiresConfirmation(),
                ActionGroup::make([
                    //
                    DeleteAction::make()->hidden(),
                ]),
            ])
            ->toolbarActions([BulkActionGroup::make([])]);
    }
}
