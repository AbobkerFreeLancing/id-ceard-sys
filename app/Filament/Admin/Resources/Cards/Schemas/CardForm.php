<?php

namespace App\Filament\Admin\Resources\Cards\Schemas;

use App\Enums\CardStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('card_uid')
                    ->required(),
                Select::make('cardholder_id')
                    ->relationship('cardholder', 'id')
                    ->required(),
                Select::make('template_id')
                    ->relationship('template', 'name')
                    ->required(),
                Textarea::make('qr_payload')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(CardStatus::class)
                    ->default('active')
                    ->required(),
                DateTimePicker::make('issued_at'),
                DateTimePicker::make('expires_at'),
                TextInput::make('print_count')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
