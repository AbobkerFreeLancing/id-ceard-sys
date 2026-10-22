<?php

namespace App\Filament\Resources\University\Courses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Packages\University\Models\Course;

class CourseForm
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
                                TextInput::make('name_en')->label(__('backend.name_en'))->maxLength(80),
                                TextInput::make('code')->label(__('backend.code'))->maxLength(30),
                                TextInput::make('credit_hours')
                                    ->label(__('backend.credit_hours'))
                                    ->numeric()
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
                                ->state(fn(Course $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Course $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(Course $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?Course $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
