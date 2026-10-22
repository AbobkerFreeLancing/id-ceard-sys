<?php

namespace App\Filament\Resources\University\StudentInterviews\Schemas;

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
use Packages\University\Enums\StudentInterviewStatusEnum;
use Packages\University\Models\Student;
use Packages\University\Models\StudentInterview;

class StudentInterviewForm
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
                                Select::make('student_id')
                                    ->label(__('backend.student'))
                                    ->options(
                                        Student::query()
                                            ->get()
                                            ->mapWithKeys(fn($s) => [
                                                $s->id => ($s->university_no ? "[{$s->university_no}] " : '') . $s->name,
                                            ]),
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        if ($state) {
                                            $student = Student::with('academicRecord')->find($state);
                                            if ($student?->academicRecord) {
                                                if ($student->academicRecord->college_id) {
                                                    $set('college_id', $student->academicRecord->college_id);
                                                }
                                                if ($student->academicRecord->academic_year_id) {
                                                    $set('academic_year_id', $student->academicRecord->academic_year_id);
                                                }
                                            }
                                        }
                                    }),
                                Select::make('college_id')
                                    ->label(__('backend.college'))
                                    ->relationship('college', 'name')
                                    ->preload()
                                    ->searchable(),
                                Select::make('academic_year_id')
                                    ->label(__('backend.academic_year'))
                                    ->relationship('academicYear', 'name')
                                    ->preload()
                                    ->searchable(),
                            ]),

                        Section::make(__('backend.interview_evaluation'))
                            ->compact()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('evaluator_display')
                                    ->label(__('backend.conducted_by'))
                                    ->state(fn() => auth()->user()?->name . ' (المستخدم الحالي بالجلسة)'),
                                TextEntry::make('auto_date_display')
                                    ->label(__('backend.interview_date'))
                                    ->state(fn(?StudentInterview $record) => $record?->interview_date?->format('Y-m-d') ?? now()->format('Y-m-d')),
                                TextInput::make('committee_members')
                                    ->label(__('backend.committee_members'))
                                    ->placeholder('د. فلان، د. علان...')
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                            ]),

                        Section::make(__('backend.interview_decision'))
                            ->compact()
                            ->columns(1)
                            ->schema([
                                Radio::make('status')
                                    ->label(__('backend.interview_status'))
                                    ->options(StudentInterviewStatusEnum::getOptions())
                                    ->default(StudentInterviewStatusEnum::Pending->value)
                                    ->inline(true)
                                    ->live()
                                    ->required()
                                    ->columnSpanFull(),

                                Textarea::make('rejection_reason')
                                    ->label(__('backend.rejection_reason'))
                                    ->placeholder(__('backend.rejection_reason_placeholder'))
                                    ->visible(function (Get $get) {
                                        $val = $get('status');
                                        return $val === StudentInterviewStatusEnum::Rejected->value || $val === 'rejected' || $val === StudentInterviewStatusEnum::Rejected;
                                    })
                                    ->required(function (Get $get) {
                                        $val = $get('status');
                                        return $val === StudentInterviewStatusEnum::Rejected->value || $val === 'rejected' || $val === StudentInterviewStatusEnum::Rejected;
                                    })
                                    ->rows(3)
                                    ->maxLength(1000)
                                    ->columnSpanFull()
                                    ->helperText('يجب كتابة وتوضيح سبب الرفض بالتفصيل عند اختيار حالة (مرفوض)'),

                                Textarea::make('notes')
                                    ->label(__('backend.interview_notes'))
                                    ->rows(3)
                                    ->maxLength(1000)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make()
                            ->compact()
                            ->schema([
                                TextInput::make('ref_number')
                                    ->label(__('backend.ref_number'))
                                    ->default(fn() => 'INT-' . date('Ymd') . '-' . rand(100, 999))
                                    ->readOnly(),
                                TextEntry::make('created_at')
                                    ->label(__('backend.created_at'))
                                    ->state(fn(?StudentInterview $record): ?string => $record?->created_at?->diffForHumans())
                                    ->hidden(fn(?StudentInterview $record) => $record === null),
                                TextEntry::make('updated_at')
                                    ->label(__('backend.updated_at'))
                                    ->state(fn(?StudentInterview $record): ?string => $record?->updated_at?->diffForHumans())
                                    ->hidden(fn(?StudentInterview $record) => $record === null),
                                TextEntry::make('conducted_by.name')
                                    ->label(__('backend.conducted_by'))
                                    ->state(fn(?StudentInterview $record): ?string => $record?->conductedBy?->name)
                                    ->hidden(fn(?StudentInterview $record) => $record?->conducted_by === null),
                                TextEntry::make('conducted_at')
                                    ->label(__('backend.conducted_at'))
                                    ->state(fn(?StudentInterview $record): ?string => $record?->conducted_at?->format('Y-m-d H:i'))
                                    ->hidden(fn(?StudentInterview $record) => $record?->conducted_at === null),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }
}
