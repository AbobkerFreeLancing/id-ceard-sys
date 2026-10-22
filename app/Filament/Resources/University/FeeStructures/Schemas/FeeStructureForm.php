<?php

namespace App\Filament\Resources\University\FeeStructures\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Packages\University\Models\Batch;
use Packages\University\Models\FeeStructure;

class FeeStructureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make()
                            ->compact()
                            ->columns(3)
                            ->schema([
                                Select::make('acceptance_type_id')
                                    ->label(__('backend.acceptance_type'))
                                    ->relationship(
                                        'acceptanceType',
                                        'name',
                                        fn($query) => $query->where('is_active', true),
                                    )
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Select::make('currency_id')
                                    ->label(__('backend.currency'))
                                    ->relationship('currency', 'name', fn($query) => $query->where('is_enabled', true))
                                    ->preload()
                                    ->searchable()
                                    ->default(getMainCurrency()->id)
                                    ->required(),
                                Select::make('academic_year_id')
                                    ->label(__('backend.academic_year'))
                                    ->relationship(
                                        'academicYear',
                                        'name',
                                        fn($query) => $query->where('is_active', true),
                                    )
                                    ->preload()
                                    ->searchable()
                                    ->default(currentAcademicYear()->id)
                                    ->required(),
                                Select::make('college_id')
                                    ->label(__('backend.college'))
                                    ->relationship('college', 'name', fn($query) => $query->where('is_active', true))
                                    ->preload()
                                    ->searchable()
                                    ->live()
                                    ->required(fn($get) => $get('is_medical_checkup_structure') == false)
                                    ->hidden(fn($get) => $get('is_medical_checkup_structure') == true)
                                    ->afterStateUpdated(fn(Set $set) => $set('department_id', null)),

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
                                    ->required()
                                    ->required(fn($get) => $get('is_medical_checkup_structure') == false)
                                    ->hidden(fn($get) => $get('is_medical_checkup_structure') == true)
                                    ->live(),

                                Select::make('level_id')
                                    ->label(__('backend.level'))
                                    ->relationship('level', 'name', fn(Builder $query) => $query->orderBy('sort_order'))
                                    ->preload()
                                    ->searchable()
                                    ->required(fn($get) => $get('is_medical_checkup_structure') == false)
                                    ->hidden(fn($get) => $get('is_medical_checkup_structure') == true),
                            ]),
                        Section::make()
                            ->compact()
                            ->schema([
                                Toggle::make('is_medical_checkup_structure')
                                    ->label(__('backend.is_medical_checkup_structure'))
                                    ->live(debounce: 1000)
                                    ->afterStateUpdated(function ($get, $set) {
                                        $set('items', []);
                                    }),
                            ]),
                        Repeater::make('items')
                            ->label(__('backend.items'))
                            ->relationship('items')
                            ->required()
                            ->minItems(1)
                            ->table([
                                TableColumn::make(__('backend.fee_type'))->alignment(Alignment::Start)->width('280px'),
                                TableColumn::make(__('backend.amount'))->width('100px')->alignment(Alignment::Start),
                            ])
                            ->schema([
                                Select::make('fee_type_id')
                                    ->label(__('backend.fee_type'))
                                    ->relationship('feeType', 'name', function ($query, $get) {
                                        return $get('../../is_medical_checkup_structure') == false
                                            ? $query->where('is_active', true)->orderBy('sort_order', 'ASC')
                                            : $query->where('code', 'medical_checkup_fees');
                                    })
                                    ->required()
                                    ->preload()
                                    ->searchable()
                                    ->distinct(),
                                TextInput::make('amount')
                                    ->label(__('backend.amount'))
                                    ->numeric()
                                    ->required()
                                    ->minValue(0),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
            ])
            ->columns(1);
    }
}
