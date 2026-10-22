<?php

namespace App\Filament\Resources\Common\Countries\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('backend.name'))
                            ->maxLength(85)
                            ->unique(ignoreRecord: true)
                            ->required(),
                    ])
            ])->columns(1);
    }
}
