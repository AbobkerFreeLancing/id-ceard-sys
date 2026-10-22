<?php

namespace App\Filament\Resources\University\BatchTransitions\Schemas;

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
use Packages\University\Models\Batch;
use Packages\University\Models\BatchTransition;

class BatchTransitionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make()
                            ->compact()
                            ->columns(1)
                            ->schema([
                                Select::make('batch_id')
                                    ->label(__('backend.batch'))
                                    ->relationship('batch', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->live(debounce: 1000),
                            ]),
                        Section::make()
                            ->compact()
                            ->columns(3)
                            ->visible(fn(Get $get) => $get('batch_id') !== null)
                            ->schema([
                                TextEntry::make('code')
                                    ->label(__('backend.code'))
                                    ->icon(Heroicon::CodeBracketSquare)
                                    ->state(fn(Get $get) => Batch::find($get('batch_id'))->code),
                                TextEntry::make('academic_year')
                                    ->label(__('backend.academic_year'))
                                    ->icon(Heroicon::Calendar)
                                    ->state(fn(Get $get) => Batch::find($get('batch_id'))->academicYear->name),
                                TextEntry::make('students')
                                    ->label(__('backend.students'))
                                    ->icon(Heroicon::UserGroup)
                                    ->state(fn(Get $get) => Batch::find($get('batch_id'))->students()->count()),
                                TextEntry::make('college')
                                    ->label(__('backend.college'))
                                    ->icon(Heroicon::BuildingOffice)
                                    ->state(fn(Get $get) => Batch::find($get('batch_id'))->college->name),
                                TextEntry::make('department')
                                    ->label(__('backend.department'))
                                    ->icon(Heroicon::BuildingLibrary)
                                    ->state(fn(Get $get) => Batch::find($get('batch_id'))->department->name),
                            ]),
                        Section::make()
                            ->compact()
                            ->columns(2)
                            ->hidden(fn(Get $get) => $get('batch_id') === null)
                            ->schema([
                                Select::make('academic_year_id')
                                    ->label(__('backend.academic_year'))
                                    ->relationship('academicYear', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->live(debounce: 1000)
                                    ->afterStateUpdated(
                                        fn(Set $set, $get) => $get('academic_year_id')
                                            ? $set('semester_id', null)
                                            : null,
                                    ),
                                Select::make('semester_id')
                                    ->label(__('backend.semester'))
                                    ->relationship(
                                        'semester',
                                        'name',
                                        fn($query, $get) => $query->where('academic_year_id', $get('academic_year_id')),
                                    )
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Select::make('from_level_id')
                                    ->label(__('backend.from_level'))
                                    ->relationship('fromLevel', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Select::make('to_level_id')
                                    ->label(__('backend.to_level'))
                                    ->relationship('toLevel', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make()
                        ->compact()
                        ->schema([
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(BatchTransition $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?BatchTransition $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(BatchTransition $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?BatchTransition $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
