<?php

namespace App\Filament\Admin\Resources\Cards\Tables;

use App\Enums\CardStatus;
use App\Models\Card;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('card_uid')
                    ->label('معرّف البطاقة (UID)')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->sortable(),
                TextColumn::make('cardholder.full_name_ar')
                    ->label('حامل البطاقة')
                    ->description(fn (Card $record): string => "الرقم القومي: {$record->cardholder->national_id}")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('template.name')
                    ->label('قالب التصميم')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('الحالة الأمنية')
                    ->badge(),
                TextColumn::make('issued_at')
                    ->label('تاريخ الإصدار')
                    ->date('Y-m-d')
                    ->sortable(),
                TextColumn::make('expires_at')
                    ->label('تاريخ الانتهاء')
                    ->date('Y-m-d')
                    ->sortable()
                    ->color(fn (Card $record) => $record->expires_at && $record->expires_at->isPast() ? 'danger' : null),
                TextColumn::make('print_count')
                    ->label('مرات الطباعة')
                    ->badge()
                    ->color('info')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('حالة البطاقة')
                    ->options(CardStatus::class),
                TrashedFilter::make(),
            ])
            ->recordActions([
                // Quick Online Verification Link
                Action::make('verifyOnline')
                    ->label('فحص إلكتروني')
                    ->icon('heroicon-m-qr-code')
                    ->color('success')
                    ->url(fn (Card $record): string => route('cards.verify', ['uid' => $record->card_uid]))
                    ->openUrlInNewTab(),

                // Revoke Card
                Action::make('revoke')
                    ->label('إلغاء وسحب البطاقة')
                    ->color('danger')
                    ->icon('heroicon-m-no-symbol')
                    ->requiresConfirmation()
                    ->visible(fn (Card $record): bool => $record->status === CardStatus::Active)
                    ->action(function (Card $record): void {
                        $record->update(['status' => CardStatus::Revoked]);
                        Notification::make()
                            ->title('تم إلغاء وسحب البطاقة أمنياً')
                            ->danger()
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
