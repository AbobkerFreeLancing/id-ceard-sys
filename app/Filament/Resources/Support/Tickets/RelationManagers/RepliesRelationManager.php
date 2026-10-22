<?php

namespace App\Filament\Resources\Support\Tickets\RelationManagers;

use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Packages\Enum\TicketStatusEnum;
use Packages\University\Models\Student;

class RepliesRelationManager extends RelationManager
{
    protected static string $relationship = 'replies';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return 'سجل المحادثة والردود على التذكرة';
    }

    public static function modelLabel(): ?string
    {
        return 'رد';
    }

    protected static function getPluralModelLabel(): string
    {
        return 'ردود التذكرة';
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Textarea::make('reply')
                ->label('نص الرد أو الملاحظة')
                ->placeholder('اكتب نص الرد الموجه للطالب أو الملاحظة الداخلية هنا...')
                ->required()
                ->rows(4)
                ->columnSpanFull(),

            FileUpload::make('attachment')
                ->label('إرفاق ملف أو صورة (اختياري)')
                ->disk('public')
                ->directory('tickets/replies')
                ->maxSize(5120)
                ->columnSpanFull(),

            Toggle::make('is_internal_note')
                ->label('ملاحظة داخلية خاصة بقسم الدعم (لا تظهر للطالب في حسابه)')
                ->default(false),

            Select::make('update_ticket_status')
                ->label('تحديث حالة التذكرة بعد إرسال الرد')
                ->options(TicketStatusEnum::options())
                ->default($this->getOwnerRecord()->status?->value ?? TicketStatusEnum::InProgress->value)
                ->dehydrated(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->recordTitleAttribute('reply')
            ->columns([
                TextColumn::make('sender')
                    ->label('المرسل')
                    ->state(function ($record) {
                        if ($record->repliable instanceof Student) {
                            return $record->repliable->name . ' (طالب: ' . ($record->repliable->university_no ?? '') . ')';
                        }
                        if ($record->repliable instanceof User) {
                            return $record->repliable->name . ' (الدعم الفني)';
                        }
                        return 'مستخدم';
                    })
                    ->badge()
                    ->color(fn($record) => $record->repliable instanceof Student ? 'info' : 'primary')
                    ->icon(fn($record) => $record->repliable instanceof Student ? Heroicon::OutlinedAcademicCap : Heroicon::OutlinedLifebuoy),

                TextColumn::make('reply')
                    ->label('نص الرد')
                    ->wrap()
                    ->limit(100)
                    ->searchable(),

                IconColumn::make('is_internal_note')
                    ->label('ملاحظة داخلية')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedLockClosed)
                    ->falseIcon(Heroicon::OutlinedLockOpen)
                    ->trueColor('warning')
                    ->falseColor('gray'),

                TextColumn::make('attachment')
                    ->label('المرفق')
                    ->state(fn($record) => $record->attachment ? 'يوجد مرفق' : '—')
                    ->badge()
                    ->color(fn($record) => $record->attachment ? 'success' : 'gray')
                    ->url(fn($record) => $record->attachment ? \Illuminate\Support\Facades\Storage::url($record->attachment) : null)
                    ->openUrlInNewTab(),

                TextColumn::make('created_at')
                    ->label('تاريخ الإرسال')
                    ->dateTime('Y-m-d H:i')
                    ->since()
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('إضافة رد للطالب / ملاحظة داخلية')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->color('primary')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['repliable_type'] = User::class;
                        $data['repliable_id'] = auth()->id();
                        return $data;
                    })
                    ->after(function ($livewire, $record, array $data) {
                        if (!empty($data['update_ticket_status'])) {
                            $ticket = $this->getOwnerRecord();
                            $ticket->status = $data['update_ticket_status'];
                            if ($data['update_ticket_status'] === TicketStatusEnum::Closed->value) {
                                $ticket->closed_at = now();
                            }
                            $ticket->save();
                        }
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
