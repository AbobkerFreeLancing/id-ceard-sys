<?php

namespace App\Filament\Resources\University\AcademicYears\Schemas;

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
use Packages\University\Models\AcademicYear;

class AcademicYearForm
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
                                TextInput::make('year')
                                    ->label(__('backend.year'))
                                    ->maxLength(20)
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                DatePicker::make('start_date')->label(__('backend.start_date')),
                                DatePicker::make('end_date')->label(__('backend.end_date')),
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
                                ->state(fn(AcademicYear $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?AcademicYear $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(AcademicYear $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?AcademicYear $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
