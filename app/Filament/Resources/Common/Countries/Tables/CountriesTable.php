<?php

namespace App\Filament\Resources\Common\Countries\Tables;

use Filament\Tables\Table;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;

class CountriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->defaultSort("name", "desc")
            ->columns([
                TextColumn::make('id')->label('#'),
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                ToggleColumn::make('is_enabled')->label(__('backend.is_enabled')),
                TextColumn::make('iso')->label('iso'),
                TextColumn::make('nicename')->label('Nicename')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('phonecode')->label(__('backend.phone_code')),
            ])
            ->filters([
                TernaryFilter::make('is_enabled')
                    ->label(__('backend.is_enabled'))
                    ->default(true),
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
            ])
            ->toolbarActions([
                BulkAction::make('enable_action')
                    ->label(__("backend.enable_action"))
                    ->outlined()
                    ->icon(Heroicon::OutlinedLockOpen)
                    ->requiresConfirmation()
                    ->color(Color::Green)
                    ->action(function ($records) {
                        $records->each(function ($record) {
                            $record->is_enabled = true;
                            $record->save();
                        });
                    }),
                BulkAction::make('disable_action')
                    ->label(__("backend.disable_action"))
                    ->outlined()
                    ->icon(Heroicon::OutlinedLockClosed)
                    ->requiresConfirmation()
                    ->color(Color::Red)
                    ->action(function ($records) {
                        $records->each(function ($record) {
                            $record->is_enabled = false;
                            $record->save();
                        });
                    })
            ]);
    }
}
