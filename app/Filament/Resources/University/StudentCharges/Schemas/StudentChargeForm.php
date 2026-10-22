<?php

namespace App\Filament\Resources\University\StudentCharges\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Packages\University\Models\StudentCharge;

class StudentChargeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make()
                            ->compact()
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('backend.name'))
                                    ->maxLength(80)
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                // Select::make('xxx_id')
                                //     ->label(__('backend.xxx'))
                                //     ->relationship('xxx', 'name')
                                //     ->preload()
                                //     ->searchable()
                                //      ->required(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make()
                        ->compact()
                        ->schema([
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(StudentCharge $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?StudentCharge $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(StudentCharge $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?StudentCharge $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
