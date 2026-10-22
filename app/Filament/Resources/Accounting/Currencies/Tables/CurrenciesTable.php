<?php

namespace App\Filament\Resources\Accounting\Currencies\Tables;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class CurrenciesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                TextColumn::make('symbol')->label(__('backend.symbol')),
                TextColumn::make('exchange_rate')
                    ->label(__('backend.exchange_rate'))
                    ->formatStateUsing(fn($state) => $state < 1 ? $state . ' ' . getMainCurrency()?->symbol : number_format($state, 0) . ' ' . getMainCurrency()?->symbol),
                TextColumn::make('reverse_exchange_rate')->label(__('backend.reverse_exchange_rate'))
                    ->formatStateUsing(fn($state) => getMainCurrency()?->symbol . ' = ' . $state < 1 ? $state :  getMainCurrency()?->symbol . ' = ' . number_format($state, 2)),
                IconColumn::make('is_main')->label(__('backend.main_currency'))->boolean(),
                ToggleColumn::make('is_enabled')->label(__('backend.is_enabled')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('set_as_main_currency')->label(__('backend.set_as_main_currency'))
                    ->icon('heroicon-o-cursor-arrow-rays')->hidden(fn($record) => $record->is_main)
                    ->color(Color::Red)
                    ->action(function ($record) {
                        $setg = Setting::find(1);
                        $setg->currency_id = $record->id;
                        $record->exchange_rate = 1;
                        $record->reverse_exchange_rate = 1;
                        // Save
                        $record->save();
                        $setg->save();
                    })->requiresConfirmation(),
                EditAction::make()
                    ->modalWidth(Width::ExtraLarge)
                    ->iconButton()
                    ->modalHeading(fn($record) => __('backend.action_edit') . ' ' . $record->name),
                DeleteAction::make()
                    ->iconButton()
                    ->visible(fn() => auth()->user()->hasRole('dev')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
