<?php

namespace App\Filament\Resources\University\CourseAllocations\Schemas;

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
use Packages\University\Models\CourseAllocation;

class CourseAllocationForm
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
                                Select::make('course_id')
                                    ->label(__('backend.course'))
                                    ->relationship('course', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Select::make('department_id')
                                    ->label(__('backend.department'))
                                    ->relationship('department', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Select::make('state_id')
                                    ->label(__('backend.state'))
                                    ->relationship(
                                        'state',
                                        'name',
                                        modifyQueryUsing: fn($query) => $query->where('is_enabled', true),
                                    )
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Select::make('academic_year_id')
                                    ->label(__('backend.academic_year'))
                                    ->relationship(
                                        'academicYear',
                                        'name',
                                        modifyQueryUsing: fn($query) => $query->whereNotNull('name'),
                                    )
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->live(debounce: 1000)
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $academicYearId = $get('academic_year_id');
                                        if ($academicYearId) {
                                            $set('semester_id', null);
                                        }
                                    }),
                                Select::make('semester_id')
                                    ->label(__('backend.semester'))
                                    ->relationship(
                                        'semester',
                                        'name',
                                        modifyQueryUsing: function ($query, Get $get) {
                                            $academicYearId = $get('academic_year_id');
                                            if ($academicYearId) {
                                                $query->where('academic_year_id', $academicYearId);
                                            }
                                        },
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
                                ->state(fn(CourseAllocation $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?CourseAllocation $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(CourseAllocation $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?CourseAllocation $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
