<?php

namespace App\Filament\Resources\University\Colleges\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Packages\University\Enums\CollegeProgramTypeEnum;
use Packages\University\Models\College;

class CollegeForm
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
                                TextInput::make('code')
                                    ->label(__('backend.code'))
                                    ->maxLength(30)
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                TextInput::make('name_en')->label(__('backend.name_en'))->maxLength(80)->required(),
                                Select::make('program_type')
                                    ->label(__('backend.program_type'))
                                    ->options(CollegeProgramTypeEnum::getOptions())
                                    ->preload()
                                    ->required(),
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
                                ->state(fn(College $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?College $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(College $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?College $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
