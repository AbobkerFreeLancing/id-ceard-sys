<?php

namespace App\Filament\Resources\University\Payments\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use App\Filament\Resources\University\Payments\PaymentResource;
use Filament\Tables\Enums\FiltersLayout;
use Packages\University\Enums\PaymentShortStatusEnum;
use Packages\University\Models\Payment;
use Packages\University\Models\Student;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ref_number')->label(__('backend.ref_number'))->searchable(),
                TextColumn::make('amount')->label(__('backend.amount')),
                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => PaymentShortStatusEnum::tryFrom($state)->getLabel())
                    ->badge()
                    ->color(fn($state) => PaymentShortStatusEnum::tryFrom($state)->getColor())
                    ->label(__('backend.amount')),
                TextColumn::make('student_name')
                    ->getStateUsing(function ($record) {
                        return $record?->charge?->student?->name ?? $record?->student?->name;
                    })
                    ->label(__('backend.student')),
                TextColumn::make('created_at')->label(__('backend.created_at'))->date(),
            ])
            ->filters(
                [
                    SelectFilter::make('student_id')
                        ->label(__('backend.student'))
                        ->options(Student::get()->pluck('name', 'id'))
                        ->query(
                            fn(Builder $query, array $data): Builder => $query->when(
                                $data['value'] ?? null,
                                fn(Builder $query, $studentId): Builder => $query->whereHas(
                                    'charge.student',
                                    fn(Builder $query): Builder => $query->whereKey($studentId),
                                ),
                            ),
                        )
                        ->preload()
                        ->searchable(),
                ],
                layout: FiltersLayout::AboveContent,
            )
            ->recordActions([
                ViewAction::make()->iconButton(),
                Action::make('invoice')
                    ->label(__('backend.payment_invoice'))
                    ->icon('heroicon-o-document-text')
                    ->url(fn(Payment $record): string => PaymentResource::getUrl('invoice', ['record' => $record]))
                    ->iconButton(),
                EditAction::make()->iconButton()->hidden(),
                ActionGroup::make([
                    //
                    DeleteAction::make()->hidden(),
                ]),
            ])
            ->toolbarActions([
                BulkAction::make('printSelected')
                    ->label(__('backend.print_selected_payments'))
                    ->icon('heroicon-o-printer')
                    ->accessSelectedRecords()
                    ->action(function (Collection $records, Component $livewire): void {
                        $livewire->redirect(
                            PaymentResource::getUrl('print-selected', [
                                'records' => implode(',', $records->modelKeys()),
                            ]),
                        );
                    }),
            ]);
    }
}
