<?php

namespace App\Filament\Resources\Support\Tickets\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Packages\Enum\PriorityEnum;
use Packages\Enum\TicketStatusEnum;
use Packages\Support\Models\Ticket;
use Packages\Support\Models\TicketCategory;
use Packages\Support\Models\TicketReply;
use Packages\IdCard\Models\Cardholder;

class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->recordUrl(fn($record) => route('filament.admin.resources.support.tickets.edit', ['record' => $record]))
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('رقم التذكرة')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label(__('backend.title'))
                    ->weight('bold')
                    ->searchable()
                    ->limit(35),

                TextColumn::make('submitter')
                    ->label('مقدم الطلب')
                    ->state(fn($record) => $record->submitter_name)
                    ->description(fn($record) => $record->is_from_cardholder ? ('حامل بطاقة - الرقم: ' . ($record->cardholder?->identifier_code ?? '—')) : null)
                    ->badge(fn($record) => $record->is_from_cardholder)
                    ->color(fn($record) => $record->is_from_cardholder ? 'info' : 'gray')
                    ->icon(fn($record) => $record->is_from_cardholder ? Heroicon::OutlinedIdentification : Heroicon::OutlinedUser)
                    ->searchable(query: function ($query, string $search) {
                        $query->whereHasMorph('ticketable', [Cardholder::class, User::class], function ($q, $type) use ($search) {
                            if ($type === Cardholder::class) {
                                $q->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%")
                                    ->orWhere('full_name_ar', 'like', "%{$search}%")
                                    ->orWhere('identifier_code', 'like', "%{$search}%")
                                    ->orWhere('national_id', 'like', "%{$search}%");
                            } else {
                                $q->where('name', 'like', "%{$search}%");
                            }
                        });
                    }),

                TextColumn::make('category.name')
                    ->label('التصنيف')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('priority')
                    ->badge()
                    ->color(fn($record) => $record->priority?->getColor() ?? 'gray')
                    ->state(fn($record) => $record->priority?->label() ?? 'متوسطة')
                    ->label(__('backend.priority')),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn($record) => match ($record->status?->value) {
                        'open' => 'info',
                        'in_progress' => 'warning',
                        'closed' => 'success',
                        default => 'gray',
                    })
                    ->state(fn($record) => $record->status?->label() ?? 'مفتوحة')
                    ->label(__('backend.status')),

                TextColumn::make('replies_count')
                    ->counts('replies')
                    ->label('الردود')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('created_at')
                    ->label(__('backend.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('حالة التذكرة')
                    ->options(TicketStatusEnum::options()),

                SelectFilter::make('priority')
                    ->label(__('backend.priority'))
                    ->options(PriorityEnum::options()),

                SelectFilter::make('ticket_category_id')
                    ->label('التصنيف والقسم')
                    ->options(fn() => TicketCategory::where('is_enabled', true)->pluck('name', 'id')),
            ])
            ->filtersTriggerAction(fn(Action $action) => $action->button()->label(__('backend.filters')))
            ->recordActions([
                // Quick Reply Action
                Action::make('quick_reply')
                    ->label('إرسال رد')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->color('primary')
                    ->modalWidth('2xl')
                    ->modalHeading(fn($record) => 'إرسال رد على التذكرة: ' . ($record->ticket_number ?? ''))
                    ->schema([
                        Textarea::make('reply')
                            ->label('نص الرد')
                            ->placeholder('اكتب نص الرد هنا...')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),

                        FileUpload::make('attachment')
                            ->label('إرفاق ملف أو مستند (اختياري)')
                            ->disk('public')
                            ->directory('tickets/replies')
                            ->maxSize(5120)
                            ->columnSpanFull(),

                        Select::make('status')
                            ->label('تحديث حالة التذكرة')
                            ->options(TicketStatusEnum::options())
                            ->default(fn($record) => $record->status?->value ?? TicketStatusEnum::InProgress->value)
                            ->required(),

                        Toggle::make('is_internal_note')
                            ->label('ملاحظة داخلية خاصة بقسم الدعم (لا تظهر للعميل)')
                            ->default(false),
                    ])
                    ->action(function ($record, array $data) {
                        TicketReply::create([
                            'ticket_id' => $record->id,
                            'repliable_type' => User::class,
                            'repliable_id' => auth()->id(),
                            'reply' => $data['reply'],
                            'attachment' => $data['attachment'] ?? null,
                            'is_internal_note' => $data['is_internal_note'] ?? false,
                        ]);

                        if (!empty($data['status'])) {
                            $record->status = $data['status'];
                            if ($data['status'] === TicketStatusEnum::Closed->value) {
                                $record->closed_at = now();
                            }
                            $record->save();
                        }

                        Notification::make()
                            ->success()
                            ->title('تم إرسال الرد بنجاح')
                            ->body('تمت إضافة ردك إلى التذكرة بنجاح.')
                            ->send();
                    }),

                // Status Update Action
                Action::make('status_update')
                    ->modalWidth('md')
                    ->color('warning')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->label(__('backend.update_status'))
                    ->schema([
                        Select::make('status')
                            ->label(__('backend.status'))
                            ->options(function ($record) {
                                $options = TicketStatusEnum::options();
                                unset($options[$record->status?->value]);
                                return $options;
                            })
                            ->required(),
                    ])
                    ->action(function ($record, $data) {
                        $record->status = $data['status'];
                        if ($data['status'] === TicketStatusEnum::Closed->value) {
                            $record->closed_at = now();
                        }
                        $record->save();
                    }),

                EditAction::make()->iconButton(),

                ActionGroup::make([
                    DeleteAction::make()->disabled(fn($record) => !auth()->user()->can('support_ticket_management')),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
