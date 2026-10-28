<?php

namespace App\Filament\Admin\Resources\Organizations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_ar')
                    ->required(),
                TextInput::make('name_en')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                TextInput::make('logo_path'),
                TextInput::make('settings'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
