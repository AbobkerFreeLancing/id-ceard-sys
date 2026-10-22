<?php

namespace App\Filament\Resources\University\MedicalCheckups\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Packages\Enum\BloodGroupEnum;
use Packages\University\Models\MedicalCheckup;

class MedicalCheckupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make()
                            ->compact()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('')
                            ]),
                        Section::make()
                            ->compact()
                            ->columns(2)
                            ->schema([
                                TextInput::make('medical_center')
                                    ->label(__('backend.medical_center'))
                                    ->required()
                                    ->numeric()
                                    ->maxValue(100),
                                TextInput::make('doctor_name')
                                    ->label(__('backend.doctor_name'))
                                    ->numeric()
                                    ->maxValue(100),
                            ]),
                        Section::make()
                            ->compact()
                            ->columns(2)
                            ->schema([
                                Select::make('blood_group')
                                    ->label(__('backend.blood_group'))
                                    ->options(BloodGroupEnum::options())
                                    ->required(),
                                TextInput::make('height')->label(__('backend.height_cm'))->numeric()->maxValue(250),
                                TextInput::make('weight')->label(__('backend.weight_kg'))->numeric()->maxValue(250),
                                TextInput::make('vision_status')->label(__('backend.vision_status'))->maxLength(200),
                                TextInput::make('hearing_status')->label(__('backend.hearing_status'))->maxLength(200),
                                TextInput::make('blood_pressure')->label(__('backend.blood_pressure'))->maxLength(30),
                                Textarea::make('general_notes')
                                    ->label(__('backend.general_notes'))
                                    ->rows(2)
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                            ]),
                        Section::make('الأمراض والحساسية')
                            ->compact()
                            ->columns(2)
                            ->schema([
                                Toggle::make('has_chronic_diseases')
                                    ->label(__('backend.has_chronic_diseases'))
                                    ->live(debounce: 1000),
                                Toggle::make('has_past_surgeries')
                                    ->label(__('backend.has_past_surgeries'))
                                    ->live(debounce: 1000),
                                Textarea::make('chronic_diseases_notes')
                                    ->label(__('backend.chronic_diseases_notes'))
                                    ->visible(fn($get) => $get('has_chronic_diseases') == true)
                                    ->required(fn($get) => $get('has_chronic_diseases') == true)
                                    ->rows(2)
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                                Textarea::make('surgeries_notes')
                                    ->label(__('backend.surgeries_notes'))
                                    ->visible(fn($get) => $get('has_past_surgeries') == true)
                                    ->required(fn($get) => $get('has_past_surgeries') == true)
                                    ->rows(2)
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                                Textarea::make('allergies_notes')
                                    ->label(__('backend.allergies_notes'))
                                    ->rows(2)
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make()
                        ->compact()
                        ->schema([
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(MedicalCheckup $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?MedicalCheckup $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(MedicalCheckup $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?MedicalCheckup $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
