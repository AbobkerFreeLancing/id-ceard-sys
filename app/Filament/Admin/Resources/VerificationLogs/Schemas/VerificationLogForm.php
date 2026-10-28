<?php

namespace App\Filament\Admin\Resources\VerificationLogs\Schemas;

use App\Enums\VerificationResult;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VerificationLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('card_id')
                    ->relationship('card', 'id'),
                TextInput::make('scanned_uid')
                    ->required(),
                Select::make('result')
                    ->options(VerificationResult::class)
                    ->required(),
                TextInput::make('scanned_by')
                    ->numeric(),
                TextInput::make('device_id'),
                TextInput::make('latitude')
                    ->numeric(),
                TextInput::make('longitude')
                    ->numeric(),
                TextInput::make('ip_address'),
                DateTimePicker::make('scanned_at')
                    ->required(),
            ]);
    }
}
