<?php

namespace App\Filament\Resources\University\MedicalCheckups\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Packages\University\Models\MedicalCheckup;

class MedicalCheckupInfolist
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
                                //
                                TextEntry::make('student.name')->label(__('backend.student'))->columnSpanFull(),
                            ]),
                        Section::make()
                            ->compact()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('medical_center')->label(__('backend.medical_center')),
                                TextEntry::make('doctor_name')->label(__('backend.doctor_name')),
                            ]),
                        Section::make()
                            ->compact()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('blood_group')->label(__('backend.blood_group')),
                                TextEntry::make('height')->label(__('backend.height_cm')),
                                TextEntry::make('weight')->label(__('backend.weight_kg')),
                                TextEntry::make('vision_status')->label(__('backend.vision_status')),
                                TextEntry::make('hearing_status')->label(__('backend.hearing_status')),
                                TextEntry::make('blood_pressure')->label(__('backend.blood_pressure')),
                                TextEntry::make('general_notes')->label(__('backend.general_notes'))->columnSpanFull(),
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
