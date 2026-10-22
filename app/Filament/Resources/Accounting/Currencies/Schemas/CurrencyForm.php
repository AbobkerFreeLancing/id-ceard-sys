<?php

namespace App\Filament\Resources\Accounting\Currencies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class CurrencyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('backend.name'))
                    ->visibleOn('create')
                    ->maxLength(50)
                    ->required()
                    ->unique(ignorable: fn(?Model $record): ?Model => $record),

                TextInput::make('exchange_rate')->label(__('backend.exchange_rate'))
                    ->numeric()
                    ->required()
                    ->live(debounce: 1000)
                    ->prefix(fn($record) => $record != null ? $record->symbol . " = " : '')
                    ->suffix(getMainCurrency()->symbol),
                TextInput::make('reverse_exchange_rate')
                    ->label(__('backend.reverse_exchange_rate'))
                    ->prefix(fn($record) => $record != null ? getMainCurrency()->symbol . " = " : '')
                    ->suffix(fn($record) => $record != null ? $record->symbol : '')
                    ->live(debounce: 1000)->numeric()
                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        if (is_numeric($state)) {
                            $set('exchange_rate', (1 / $state));
                        } else {
                            $set('exchange_rate', 1);
                        }
                    }),
                TextInput::make('symbol')
                    ->label(__('backend.symbol'))
                    ->visibleOn('create')
                    ->required()
                    ->maxLength(10),
            ])->columns(2);
    }
}
