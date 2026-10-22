<?php

namespace App\Filament\Resources\Common\Notes\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class NoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label(__('backend.title'))
                    ->required()
                    ->maxLength(50)
                    ->columnSpanFull(),
                Textarea::make('content')
                    ->label(__('backend.content'))
                    ->maxLength(300)
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
