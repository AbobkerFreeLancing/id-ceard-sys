<?php

namespace App\Filament\Resources\University\StudentInterviews\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Packages\University\Enums\StudentInterviewStatusEnum;
use Packages\University\Models\College;
use Packages\University\Models\Student;
use Packages\University\Models\StudentInterview;
use pxlrbt\FilamentExcel\Actions\ExportBulkAction;

class StudentInterviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('student.profile_picture')
                    ->label(__('backend.profile_picture'))
                    ->circular()
                    ->defaultImageUrl(fn($record) => $record->student?->getFilamentAvatarUrl()),
                TextColumn::make('student.university_no')->label(__('backend.university_no'))->searchable(
                    query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('student', function ($q) use ($search) {
                            $q->where('university_no', 'like', "%{$search}%");
                        });
                    },
                ),
                TextColumn::make('student.name')
                    ->label(__('backend.student'))
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {
                            return $query->whereHas('student', function ($q) use ($search) {
                                $q->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('second_name', 'like', "%{$search}%")
                                    ->orWhere('third_name', 'like', "%{$search}%")
                                    ->orWhere('fourth_name', 'like', "%{$search}%");
                            });
                        },
                    )
                    ->weight('bold')
                    ->description(fn($record) => $record->college?->name),

                TextColumn::make('academicYear.name')
                    ->label(__('backend.academic_year'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('interview_date')->label(__('backend.interview_date'))->date()->sortable(),

                TextColumn::make('status')
                    ->label(__('backend.interview_status'))
                    ->badge()
                    ->state(
                        fn(StudentInterview $record) => $record->status instanceof StudentInterviewStatusEnum
                            ? $record->status->getLabel()
                            : $record->status,
                    )
                    ->color(
                        fn(StudentInterview $record) => $record->status instanceof StudentInterviewStatusEnum
                            ? $record->status->getColor()
                            : 'gray',
                    ),

                TextColumn::make('interviewer_name')
                    ->label(__('backend.conducted_by'))
                    ->state(
                        fn(StudentInterview $record) => $record->conductedBy?->name ??
                            ($record->interviewer_name ?? '-'),
                    )
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('backend.created_at'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('backend.interview_status'))
                    ->options(StudentInterviewStatusEnum::getOptions()),

                SelectFilter::make('college_id')
                    ->label(__('backend.college'))
                    ->relationship('college', 'name')
                    ->preload()
                    ->searchable(),

                SelectFilter::make('academic_year_id')
                    ->label(__('backend.academic_year'))
                    ->relationship('academicYear', 'name')
                    ->preload()
                    ->searchable(),

                Filter::make('interview_date')
                    ->label(__('backend.interview_date'))
                    ->form([
                        DatePicker::make('from')->label(__('backend.from')),
                        DatePicker::make('to')->label(__('backend.to')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn($q, $date) => $q->whereDate('interview_date', '>=', $date))
                            ->when($data['to'], fn($q, $date) => $q->whereDate('interview_date', '<=', $date));
                    }),
            ])
            ->recordActions([
                Action::make('conduct_interview')
                    ->label(__('backend.conduct_interview'))
                    ->modalHeading(__('backend.interview_evaluation'))
                    ->modalWidth('xl')
                    ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                    ->color('primary')
                    ->fillForm(
                        fn(StudentInterview $record): array => [
                            'status' =>
                                $record->status instanceof StudentInterviewStatusEnum
                                    ? $record->status->value
                                    : $record->status ?? StudentInterviewStatusEnum::Pending->value,
                            'rejection_reason' => $record->rejection_reason,
                            'notes' => $record->notes,
                        ],
                    )
                    ->schema([
                        Group::make([
                            TextEntry::make('student_info')
                                ->label(__('backend.student'))
                                ->state(
                                    fn(StudentInterview $record) => ($record->student?->university_no
                                        ? "[{$record->student->university_no}] "
                                        : '') . $record->student?->name,
                                ),

                            TextEntry::make('college_info')
                                ->label(__('backend.college'))
                                ->state(fn(StudentInterview $record) => $record->college?->name ?? '-'),

                            TextEntry::make('conducted_by_user')
                                ->label(__('backend.conducted_by'))
                                ->state(fn() => auth()->user()?->name . ' (المستخدم الحالي بالجلسة)'),

                            TextEntry::make('current_status')
                                ->label(__('backend.current_status'))
                                ->badge()
                                ->state(
                                    fn(StudentInterview $record) => $record->status instanceof
                                    StudentInterviewStatusEnum
                                        ? $record->status->getLabel()
                                        : $record->status,
                                )
                                ->color(
                                    fn(StudentInterview $record) => $record->status instanceof
                                    StudentInterviewStatusEnum
                                        ? $record->status->getColor()
                                        : 'gray',
                                ),

                            Radio::make('status')
                                ->label(__('backend.new_status'))
                                ->options(StudentInterviewStatusEnum::getOptions())
                                ->inline(true)
                                ->required()
                                ->live(),

                            Textarea::make('rejection_reason')
                                ->label(__('backend.rejection_reason'))
                                ->placeholder(__('backend.rejection_reason_placeholder'))
                                ->visible(function (Get $get) {
                                    $val = $get('status');
                                    return $val === StudentInterviewStatusEnum::Rejected->value ||
                                        $val === 'rejected' ||
                                        $val === StudentInterviewStatusEnum::Rejected;
                                })
                                ->required(function (Get $get) {
                                    $val = $get('status');
                                    return $val === StudentInterviewStatusEnum::Rejected->value ||
                                        $val === 'rejected' ||
                                        $val === StudentInterviewStatusEnum::Rejected;
                                })
                                ->rows(3)
                                ->columnSpanFull()
                                ->helperText('يجب كتابة وتوضيح سبب الرفض بالتفصيل عند اختيار حالة (مرفوض)'),

                            Textarea::make('notes')->label(__('backend.interview_notes'))->rows(2)->columnSpanFull(),
                        ])->columns(1),
                    ])
                    ->action(function (StudentInterview $record, array $data) {
                        $status = $data['status'];
                        $isRejected =
                            $status === StudentInterviewStatusEnum::Rejected->value ||
                            $status === 'rejected' ||
                            $status === StudentInterviewStatusEnum::Rejected;
                        $rejectionReason = $isRejected ? $data['rejection_reason'] : null;

                        $record->update([
                            'status' => $status,
                            'rejection_reason' => $rejectionReason,
                            'interview_date' => now()->toDateString(),
                            'interviewer_name' => auth()->user()?->name,
                            'conducted_by' => auth()->id(),
                            'conducted_at' => now(),
                            'notes' => $data['notes'] ?? null,
                        ]);

                        Notification::make()
                            ->title(
                                __('backend.interview_decision') .
                                    ': ' .
                                    ($record->fresh()->status instanceof StudentInterviewStatusEnum
                                        ? $record->fresh()->status->getLabel()
                                        : $record->fresh()->status),
                            )
                            ->success()
                            ->send();
                    }),

                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),

                ActionGroup::make([DeleteAction::make()->visible(fn() => auth()->user()?->hasRole('dev'))]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    ExportBulkAction::make(),
                    DeleteBulkAction::make()->visible(fn() => auth()->user()?->hasRole('dev')),
                ]),
            ]);
    }
}
