<?php

namespace App\Filament\Admin\Resources\CardTemplates\Schemas;

use App\Enums\TemplateOrientation;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CardTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'id')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                Select::make('orientation')
                    ->options(TemplateOrientation::class)
                    ->default('landscape')
                    ->required(),
                TextInput::make('width_mm')
                    ->required()
                    ->numeric()
                    ->default(85.6),
                TextInput::make('height_mm')
                    ->required()
                    ->numeric()
                    ->default(54.0),
                TextInput::make('dpi')
                    ->required()
                    ->numeric()
                    ->default(300),
                TextInput::make('front_bg'),
                TextInput::make('back_bg'),
                TextInput::make('layout'),
            ]);
    }
}
