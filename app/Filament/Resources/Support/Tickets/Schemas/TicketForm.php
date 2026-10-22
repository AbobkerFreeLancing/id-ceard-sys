<?php

namespace App\Filament\Resources\Support\Tickets\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Packages\Enum\PriorityEnum;
use Packages\Enum\TicketStatusEnum;
use Packages\Support\Models\Ticket;
use Packages\Support\Models\TicketCategory;
use Packages\University\Models\Student;

class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('تفاصيل التذكرة والطلب')
                            ->schema([
                                TextInput::make('ticket_number')
                                    ->label('رقم التذكرة')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->hidden(fn(?Ticket $record) => $record === null),

                                TextInput::make('title')
                                    ->label(__('backend.title'))
                                    ->maxLength(120)
                                    ->required()
                                    ->columnSpanFull(),

                                RichEditor::make('description')
                                    ->label(__('backend.description'))
                                    ->columnSpanFull()
                                    ->toolbarButtons([
                                        ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                                        ['bold', 'underline', 'superscript', 'link'],
                                        ['bulletList', 'orderedList'],
                                        ['undo', 'redo'],
                                    ])
                                    ->required(),

                                FileUpload::make('attachment')
                                    ->label('المرفق المرفوع مع التذكرة')
                                    ->disk('public')
                                    ->directory('tickets/attachments')
                                    ->image()
                                    ->openable()
                                    ->downloadable()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        // Section for Student Information if submitter is a Student
                        Section::make('بيانات الطالب صاحب التذكرة')
                            ->description('بيانات الطالب الأكاديمية والشخصية المسجلة في النظام')
                            ->schema([
                                TextEntry::make('student_full_name')
                                    ->label('اسم الطالب')
                                    ->state(fn(Ticket $record): string => $record->student?->name ?? '—'),

                                TextEntry::make('student_university_no')
                                    ->label('الرقم الجامعي')
                                    ->state(fn(Ticket $record): string => $record->student?->university_no ?? '—')
                                    ->badge()
                                    ->color('primary'),

                                TextEntry::make('student_national_id')
                                    ->label('الرقم الوطني')
                                    ->state(fn(Ticket $record): string => $record->student?->national_id_number ?? '—'),

                                TextEntry::make('student_college')
                                    ->label('الكلية والقسم')
                                    ->state(fn(Ticket $record): string => ($record->student?->academicRecord?->college?->name ?? '—') . ' / ' . ($record->student?->academicRecord?->department?->name ?? '—')),

                                TextEntry::make('student_picture_preview')
                                    ->label('الصورة الشخصية الحالية للطالب')
                                    ->state(function (Ticket $record): string {
                                        $pic = $record->student?->profile_picture_url;
                                        return $pic ? "<img src='{$pic}' style='width: 70px; height: 70px; object-fit: cover; border-radius: 12px; border: 1.5px solid #cbd5e1;' />" : 'لا توجد صورة';
                                    })
                                    ->html()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->hidden(fn(?Ticket $record) => $record === null || !$record->is_from_student),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()->schema([
                    Section::make(__('backend.extra_info'))
                        ->schema([
                            Select::make('status')
                                ->label(__('backend.status'))
                                ->options(TicketStatusEnum::options())
                                ->required()
                                ->default(TicketStatusEnum::Open->value),

                            Select::make('priority')
                                ->label(__('backend.priority'))
                                ->options(PriorityEnum::options())
                                ->required()
                                ->default(PriorityEnum::Medium->value),

                            Select::make('ticket_category_id')
                                ->label(__('backend.category'))
                                ->relationship('category', 'name', fn($query) => $query->where('is_enabled', true))
                                ->preload()
                                ->searchable()
                                ->required(),

                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(Ticket $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Ticket $record) => $record === null),

                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(Ticket $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?Ticket $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
