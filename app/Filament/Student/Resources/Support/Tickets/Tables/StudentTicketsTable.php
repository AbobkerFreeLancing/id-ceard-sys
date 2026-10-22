<?php

namespace App\Filament\Student\Resources\Support\Tickets\Tables;

use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Packages\Enum\TicketStatusEnum;

class StudentTicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->recordUrl(fn($record) => \App\Filament\Student\Resources\Support\Tickets\StudentTicketResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('رقم التذكرة')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('موضوع التذكرة / الطلب')
                    ->weight('bold')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn($record) => match ($record->status?->value) {
                        'open' => 'info',
                        'in_progress' => 'warning',
                        'closed' => 'success',
                        default => 'gray',
                    })
                    ->state(fn($record) => $record->status?->label() ?? 'مفتوحة'),

                TextColumn::make('replies_count')
                    ->counts('replies')
                    ->label('الردود')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('created_at')
                    ->label('تاريخ الفتح')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('حالة التذكرة')
                    ->options(TicketStatusEnum::options()),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('عرض المحادثة والردود')
                    ->icon(Heroicon::OutlinedChatBubbleLeftRight)
                    ->color('primary'),
            ])
            ->emptyStateHeading('لا توجد تذاكر دعم فني حالياً')
            ->emptyStateDescription('إذا كانت لديك مشكلة أو ترغب في تعديل بياناتك أو صورتك الشخصية، اضغط على زر فتح تذكرة جديدة للتواصل مع الدعم الفني.')
            ->emptyStateIcon(Heroicon::OutlinedLifebuoy);
    }
}
