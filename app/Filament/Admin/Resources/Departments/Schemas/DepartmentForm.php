<?php

namespace App\Filament\Admin\Resources\Departments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'id')
                    ->required(),
                Select::make('parent_id')
                    ->relationship('parent', 'id'),
                TextInput::make('type'),
                TextInput::make('name_ar')
                    ->required(),
                TextInput::make('name_en')
                    ->required(),
                TextInput::make('path'),
                TextInput::make('depth')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
