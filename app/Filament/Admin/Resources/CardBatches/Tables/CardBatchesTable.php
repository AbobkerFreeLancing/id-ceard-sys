<?php

namespace App\Filament\Admin\Resources\CardBatches\Tables;

use App\Enums\BatchStatus;
use App\Models\CardBatch;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CardBatchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('batch_no')
                    ->label('رقم الدفعة')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->sortable(),
                TextColumn::make('template.name')
                    ->label('القالب المعتمد')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('حالة الدفعة')
                    ->badge(),
                TextColumn::make('cards_per_sheet')
                    ->label('بطاقة/ورقة A4')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('total_cards')
                    ->label('إجمالي البطاقات')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('creator.name')
                    ->label('أنشئت بواسطة')
                    ->placeholder('النظام'),
                TextColumn::make('printed_at')
                    ->label('وقت الطباعة')
                    ->dateTime('Y-m-d H:i')
                    ->placeholder('لم تطبع بعد')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('حالة الدفعة')
                    ->options(BatchStatus::class),
                TrashedFilter::make(),
            ])
            ->recordActions([
                // Confirm Printing Action
                Action::make('confirmPrint')
                    ->label('تأكيد إتمام الطباعة')
                    ->icon('heroicon-m-printer')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (CardBatch $record): bool => $record->status !== BatchStatus::Printed)
                    ->action(function (CardBatch $record): void {
                        $record->update([
                            'status' => BatchStatus::Printed,
                            'printed_at' => now(),
                        ]);

                        // Increment print count on all batch cards
                        foreach ($record->cards as $card) {
                            $card->increment('print_count');
                        }

                        Notification::make()
                            ->title('تم اعتماد طباعة الدفعة وتحديث عدادات البطاقات بنجاح')
                            ->success()
                            ->send();
                    }),

                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
