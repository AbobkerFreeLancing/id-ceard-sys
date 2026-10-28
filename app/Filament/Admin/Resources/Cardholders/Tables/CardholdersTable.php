<?php

namespace App\Filament\Admin\Resources\Cardholders\Tables;

use App\Enums\CardholderAuditStatus;
use App\Enums\CardStatus;
use App\Models\Card;
use App\Models\Cardholder;
use App\Models\CardTemplate;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CardholdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo_path')
                    ->label('الصورة')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('full_name_ar')
                    ->label('الاسم الكامل')
                    ->description(fn (Cardholder $record): string => $record->full_name_en)
                    ->searchable(['full_name_ar', 'full_name_en'])
                    ->sortable(),
                TextColumn::make('national_id')
                    ->label('الرقم القومي')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('organization.name_ar')
                    ->label('المؤسسة')
                    ->sortable(),
                TextColumn::make('department.name_ar')
                    ->label('القسم')
                    ->placeholder('العام'),
                TextColumn::make('audit_status')
                    ->label('حالة التدقيق')
                    ->badge(),
                TextColumn::make('activeCard.card_uid')
                    ->label('البطاقة النشطة')
                    ->placeholder('لا توجد بطاقة')
                    ->copyable()
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray'),
                TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('audit_status')
                    ->label('حالة التدقيق')
                    ->options(CardholderAuditStatus::class),
                SelectFilter::make('organization_id')
                    ->label('المؤسسة')
                    ->relationship('organization', 'name_ar'),
                TrashedFilter::make(),
            ])
            ->recordActions([
                // 1. Quick Approve Action
                Action::make('approve')
                    ->label('اعتماد للطباعة')
                    ->color('success')
                    ->icon('heroicon-m-check-badge')
                    ->requiresConfirmation()
                    ->visible(fn (Cardholder $record): bool => $record->audit_status !== CardholderAuditStatus::Approved)
                    ->action(function (Cardholder $record): void {
                        $record->update([
                            'audit_status' => CardholderAuditStatus::Approved,
                            'audited_by' => auth()->id(),
                        ]);
                        Notification::make()
                            ->title('تم اعتماد بيانات حامل الهوية للطباعة')
                            ->success()
                            ->send();
                    }),

                // 2. Quick Reject Action
                Action::make('reject')
                    ->label('رفض البيانات')
                    ->color('danger')
                    ->icon('heroicon-m-x-circle')
                    ->visible(fn (Cardholder $record): bool => $record->audit_status !== CardholderAuditStatus::Rejected)
                    ->schema([
                        Textarea::make('audit_notes')
                            ->label('سبب الرفض والملاحظات المطلوبة للتصحيح')
                            ->required(),
                    ])
                    ->action(function (array $data, Cardholder $record): void {
                        $record->update([
                            'audit_status' => CardholderAuditStatus::Rejected,
                            'audit_notes' => $data['audit_notes'],
                            'audited_by' => auth()->id(),
                        ]);
                        Notification::make()
                            ->title('تم رفض السجل وتوجيه الملاحظات للمُدخل')
                            ->warning()
                            ->send();
                    }),

                // 3. Issue Card Action (Only if approved)
                Action::make('issueCard')
                    ->label('إصدار بطاقة')
                    ->color('info')
                    ->icon('heroicon-m-credit-card')
                    ->visible(fn (Cardholder $record): bool => $record->isApproved())
                    ->schema([
                        Select::make('template_id')
                            ->label('قالب البطاقة')
                            ->options(function (Cardholder $record) {
                                return CardTemplate::where('organization_id', $record->organization_id)
                                    ->pluck('name', 'id');
                            })
                            ->required(),
                        DatePicker::make('expires_at')
                            ->label('تاريخ انتهاء البطاقة')
                            ->default(now()->addYears(2))
                            ->required(),
                    ])
                    ->action(function (array $data, Cardholder $record): void {
                        $card = Card::create([
                            'cardholder_id' => $record->id,
                            'template_id' => $data['template_id'],
                            'status' => CardStatus::Active,
                            'issued_at' => now(),
                            'expires_at' => $data['expires_at'],
                        ]);

                        Notification::make()
                            ->title("تم إصدار البطاقة الذكية بنجاح برمز: {$card->card_uid}")
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
