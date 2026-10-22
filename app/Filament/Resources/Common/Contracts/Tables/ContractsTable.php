<?php

namespace App\Filament\Resources\Common\Contracts\Tables;

use Packages\HR\Enum\EmploymentStatusEnum;
use Packages\HR\Enum\EmploymentTypeEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ContractsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ref_number')->label(__('backend.ref_number'))->searchable(),
                TextColumn::make('user.name')->label(__('backend.employee')),
                TextColumn::make('salaryStructure.name')->label(__('backend.salary_structure')),
                TextColumn::make('type')
                    ->label(__('backend.contract_type'))
                    ->badge()
                    ->color(fn($state) => EmploymentTypeEnum::from($state)->getColor())
                    ->formatStateUsing(fn($state) => EmploymentTypeEnum::from($state)->getLabel()),
                TextColumn::make('basic_salary')
                    ->label(__('backend.basic_salary'))
                    ->formatStateUsing(fn($state) => $state ? number_format($state, 2) : null),
                TextColumn::make('status')
                    ->label(__('backend.status'))
                    ->badge()
                    ->color(fn($state) => EmploymentStatusEnum::from($state)->getColor())
                    ->formatStateUsing(fn($state) => EmploymentStatusEnum::from($state)->getLabel()),
                TextColumn::make('start_date')->label(__('backend.start_date'))->date(),
                // TextColumn::make('end_date')->label(__('backend.end_date'))->date(),
                TextColumn::make('created_at')->label(__('backend.created_at'))->date(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label(__('backend.contract_type'))
                    ->options(\Packages\HR\Enum\EmploymentTypeEnum::getOptions())
                    ->preload()
                    ->searchable(),
                SelectFilter::make('salary_structure_id')
                    ->label(__('backend.salary_structure'))
                    ->relationship('salaryStructure', 'name')
                    ->preload()
                    ->searchable(),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
                EditAction::make()
                    ->iconButton(),
                ActionGroup::make([
                    Action::make('terminate_contract')
                        ->label(__('backend.terminate_contract'))
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->hidden(fn($record) => $record->status == EmploymentStatusEnum::Terminated->value)
                        ->schema([
                            Group::make([
                                TextEntry::make('ref_number')->label(__('backend.ref_number')),
                                TextEntry::make('user.name')->label(__('backend.employee')),
                                TextEntry::make('type')
                                    ->label(__('backend.contract_type'))
                                    ->badge()
                                    ->color(fn($state) => EmploymentTypeEnum::from($state)->getColor())
                                    ->formatStateUsing(fn($state) => EmploymentTypeEnum::from($state)->getLabel()),
                                DatePicker::make('termination_date')
                                    ->label(__('backend.termination_date'))
                                    ->default(now())
                                    ->required(),
                                Textarea::make('termination_reason')
                                    ->label(__('backend.termination_reason'))
                                    ->required()
                                    ->maxLength(400)
                                    ->columnSpanFull()
                            ])
                                ->columns(2)
                        ])
                        ->action(function ($record) {
                            $record->update([
                                'end_date' => now(),
                                'status' => EmploymentStatusEnum::Terminated->value,
                            ]);
                        }),
                    DeleteAction::make()
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
