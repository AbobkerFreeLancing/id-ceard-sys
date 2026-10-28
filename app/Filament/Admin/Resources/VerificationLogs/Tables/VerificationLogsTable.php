<?php

namespace App\Filament\Admin\Resources\VerificationLogs\Tables;

use App\Enums\VerificationResult;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class VerificationLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('scanned_uid')
                    ->label('الرمز المقروء (Scanned UID)')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->sortable(),
                TextColumn::make('result')
                    ->label('نتيجة الفحص')
                    ->badge(),
                TextColumn::make('card.cardholder.full_name_ar')
                    ->label('حامل البطاقة')
                    ->placeholder('رمز غير مسجل / محاولة مشبوهة')
                    ->searchable(),
                TextColumn::make('scanner.name')
                    ->label('القائم بالفحص')
                    ->placeholder('فحص عام / متصفح')
                    ->searchable(),
                TextColumn::make('ip_address')
                    ->label('عنوان IP')
                    ->fontFamily('mono')
                    ->searchable(),
                TextColumn::make('scanned_at')
                    ->label('توقيت الفحص')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
            ])
            ->defaultSort('scanned_at', 'desc')
            ->filters([
                SelectFilter::make('result')
                    ->label('نتيجة الفحص')
                    ->options(VerificationResult::class),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
