<?php

namespace App\Filament\Resources\University\Batches\Schemas;

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
use Illuminate\Database\Eloquent\Builder;
use Packages\University\Models\Batch;

class BatchForm
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
                                    ->maxLength(50)
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                TextInput::make('code')
                                    ->label(__('backend.code'))
                                    ->maxLength(30)
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                Select::make('academic_year_id')
                                    ->label(__('backend.academic_year'))
                                    ->relationship('academicYear', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->default(currentAcademicYear()->id)
                                    ->required(),
                                Select::make('college_id')
                                    ->label(__('backend.college'))
                                    ->relationship('college', 'name', fn($query) => $query->where('is_active', true))
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->live(1000)
                                    ->afterStateUpdated(fn(callable $set) => $set('department_id', null)),
                                Select::make('department_id')
                                    ->label(__('backend.department'))
                                    ->relationship(
                                        'department',
                                        'name',
                                        fn($query, Get $get) => $query
                                            ->where('is_active', true)
                                            ->where('college_id', $get('college_id')),
                                    )
                                    ->preload()
                                    ->searchable()
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
                                ->state(fn(Batch $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Batch $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(Batch $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?Batch $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
