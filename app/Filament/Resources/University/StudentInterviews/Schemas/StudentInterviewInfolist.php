<?php

namespace App\Filament\Resources\University\StudentInterviews\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Packages\University\Enums\StudentInterviewStatusEnum;
use Packages\University\Models\StudentInterview;

class StudentInterviewInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make(__('backend.student_information'))
                            ->compact()
                            ->columns(3)
                            ->schema([
                                TextEntry::make('student.university_no')
                                    ->label(__('backend.university_no'))
                                    ->weight('bold'),
                                TextEntry::make('student.name')
                                    ->label(__('backend.student'))
                                    ->weight('bold'),
                                TextEntry::make('college.name')
                                    ->label(__('backend.college')),
                                TextEntry::make('academicYear.name')
                                    ->label(__('backend.academic_year')),
                                TextEntry::make('ref_number')
                                    ->label(__('backend.ref_number')),
                            ]),

                        Section::make(__('backend.interview_evaluation'))
                            ->compact()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('interview_date')
                                    ->label(__('backend.interview_date'))
                                    ->date(),
                                TextEntry::make('interviewer_name')
                                    ->label(__('backend.conducted_by'))
                                    ->state(fn(StudentInterview $record) => $record->conductedBy?->name ?? $record->interviewer_name ?? '-'),
                                TextEntry::make('committee_members')
                                    ->label(__('backend.committee_members'))
                                    ->default('-')
                                    ->columnSpanFull(),
                            ]),

                        Section::make(__('backend.interview_decision'))
                            ->compact()
                            ->columns(1)
                            ->schema([
                                TextEntry::make('status')
                                    ->label(__('backend.interview_status'))
                                    ->badge()
                                    ->state(fn(StudentInterview $record) => $record->status instanceof StudentInterviewStatusEnum ? $record->status->getLabel() : $record->status)
                                    ->color(fn(StudentInterview $record) => $record->status instanceof StudentInterviewStatusEnum ? $record->status->getColor() : 'gray'),

                                TextEntry::make('rejection_reason')
                                    ->label(__('backend.rejection_reason'))
                                    ->color('danger')
                                    ->weight('bold')
                                    ->visible(fn(StudentInterview $record) => $record->status === StudentInterviewStatusEnum::Rejected || $record->status === 'rejected' || !empty($record->rejection_reason))
                                    ->columnSpanFull(),

                                TextEntry::make('notes')
                                    ->label(__('backend.interview_notes'))
                                    ->default('-')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make()
                            ->compact()
                            ->schema([
                                TextEntry::make('conducted_by.name')
                                    ->label(__('backend.conducted_by'))
                                    ->state(fn(StudentInterview $record) => $record->conductedBy?->name ?? '-'),
                                TextEntry::make('conducted_at')
                                    ->label(__('backend.conducted_at'))
                                    ->state(fn(StudentInterview $record) => $record->conducted_at?->format('Y-m-d H:i') ?? '-'),
                                TextEntry::make('created_at')
                                    ->label(__('backend.created_at'))
                                    ->state(fn(StudentInterview $record): ?string => $record->created_at?->diffForHumans()),
                                TextEntry::make('updated_at')
                                    ->label(__('backend.updated_at'))
                                    ->state(fn(StudentInterview $record): ?string => $record->updated_at?->diffForHumans()),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }
}
