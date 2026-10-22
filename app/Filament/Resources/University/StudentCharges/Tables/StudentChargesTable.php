<?php

namespace App\Filament\Resources\University\StudentCharges\Tables;

use App\Filament\Resources\University\StudentCharges\StudentChargeResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Packages\Enum\PaymentStatusEnum;
use Packages\University\Models\College;
use Packages\University\Models\Student;
use Packages\University\Models\StudentCharge;

class StudentChargesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ref_number')->label(__('backend.ref_number')),
                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => PaymentStatusEnum::tryFrom($state)->getLabel())
                    ->badge()
                    ->color(fn($state) => PaymentStatusEnum::tryFrom($state)->getColor())
                    ->label(__('backend.status')),
                TextColumn::make('student.name')->label(__('backend.student')),
                TextColumn::make('feeType.name')->label(__('backend.fee_type')),
                TextColumn::make('net_amount')
                    ->searchable(isIndividual: true)
                    ->label(__('backend.amount'))
                    ->summarize(Sum::make()->formatStateUsing(fn($state) => setMoney($state)))
                    ->formatStateUsing(fn($state) => setMoney($state)),
                TextColumn::make('created_at')->label(__('backend.created_at'))->date(),
            ])
            ->filters(
                [
                    SelectFilter::make('college_id')
                        ->label(__('backend.college'))
                        ->options(fn() => College::pluck('name', 'id')->toArray())
                        ->query(function ($query, array $data) {
                            if (filled($data['value'] ?? null)) {
                                $query->whereHas('feeStructure', fn($q) => $q->where('college_id', $data['value']));
                            }
                        })
                        ->searchable()
                        ->preload(),
                    SelectFilter::make('student_id')
                        ->label(__('backend.student'))
                        ->options(
                            Student::latest()
                                ->limit(1000)
                                ->get()
                                ->mapWithKeys(
                                    fn($student) => [
                                        $student->id => $student->name,
                                    ],
                                )
                                ->all(),
                        )
                        ->preload()
                        ->searchable(),
                ],
                layout: FiltersLayout::AboveContent,
            )
            ->recordActions([
                ViewAction::make(),
                Action::make('invoice')
                    ->label(__('backend.print'))
                    ->icon('heroicon-o-printer')
                    ->url(
                        fn(StudentCharge $record): string => StudentChargeResource::getUrl('invoice', [
                            'record' => $record,
                        ]),
                        true,
                    )
                    ->button()
                    ->outlined(),
                EditAction::make()->iconButton()->hidden(),
                ActionGroup::make([
                    //
                    DeleteAction::make()->hidden(),
                ]),
            ])
            ->toolbarActions([
                BulkAction::make('printSelected')
                    ->label(__('backend.print_selected_charges'))
                    ->icon('heroicon-o-printer')
                    ->accessSelectedRecords()
                    ->action(function (Collection $records, Component $livewire): void {
                        $livewire->redirect(
                            StudentChargeResource::getUrl('print-selected', [
                                'records' => implode(',', $records->modelKeys()),
                            ]),
                        );
                    }),
                BulkActionGroup::make([
                    BulkAction::make('edit_action')
                        ->label('تعديل الرسوم')
                        ->schema([
                            //
                            TextInput::make('net_amount')
                                ->label(__('backend.amount'))
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(10000000),
                        ])
                        ->requiresConfirmation()
                        ->visible(fn() => auth()->user()->hasRole('dev'))
                        ->action(
                            fn(Collection $records, $data) => $records->each->update([
                                'net_amount' => $data['net_amount'],
                            ]),
                        ),
                ]),
            ]);
    }
}
