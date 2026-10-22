<?php

namespace App\Filament\Student\Resources\University\StudentProfiles\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Packages\University\Models\Student;

class StudentProfileInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make(ucfirst(__('backend.basic_info')))
                            ->icon('heroicon-s-information-circle')
                            ->compact()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('name')->label(__('backend.full_name')),
                                TextEntry::make('full_name_en')->label(__('backend.full_name_en')),
                                TextEntry::make('gender')
                                    ->label(__('backend.gender'))
                                    ->formatStateUsing(fn($state) => $state->label()),
                                TextEntry::make('date_of_birth')->label(__('backend.date_of_birth')),
                                TextEntry::make('address')->label(__('backend.current_address')),
                                TextEntry::make('permanent_address')->label(__('backend.permanent_address')),
                                TextEntry::make('national_id_number')->label(__('backend.national_id_number')),
                            ]), // End Tab 01

                        Section::make(ucfirst(__('backend.academic_info')))
                            ->icon(Heroicon::AcademicCap)
                            ->compact()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('university_no')->label(__('backend.university_no')),
                                TextEntry::make('academicRecord.acceptanceType.name')->label(
                                    __('backend.acceptance_type'),
                                ),
                                TextEntry::make('academicRecord.college.name')->label(__('backend.college')),
                                TextEntry::make('academicRecord.department.name')->label(__('backend.department')),
                                TextEntry::make('academicRecord.level.name')->label(__('backend.level')),
                                TextEntry::make('academicRecord.batch.name')->label(__('backend.batch')),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make(ucfirst(__('backend.guardian_info')))
                        ->compact()
                        ->icon(Heroicon::User)
                        ->schema([
                            TextEntry::make('guardian_name')->label(__('backend.guardian_name')),
                            TextEntry::make('guardian_relationship')
                                ->state(fn($record) => $record?->guardian_relationship?->getLabel())
                                ->label(__('backend.relation_title')),
                            TextEntry::make('guardian_job')->label(__('backend.guardian_job')),
                            TextEntry::make('guardian_phone')->label(__('backend.guardian_phone')),
                        ]), // End Guardian info
                    Section::make()
                        ->compact()
                        ->schema([
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(Student $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Student $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(Student $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?Student $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
