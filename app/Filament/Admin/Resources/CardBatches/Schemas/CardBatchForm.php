<?php

namespace App\Filament\Admin\Resources\CardBatches\Schemas;

use App\Enums\BatchStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CardBatchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('batch_no')
                    ->required(),
                Select::make('template_id')
                    ->relationship('template', 'name')
                    ->required(),
                Select::make('status')
                    ->options(BatchStatus::class)
                    ->default('draft')
                    ->required(),
                TextInput::make('cards_per_sheet')
                    ->required()
                    ->numeric()
                    ->default(8),
                TextInput::make('total_cards')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('created_by')
                    ->numeric(),
                DateTimePicker::make('printed_at'),
            ]);
    }
}
