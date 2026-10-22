<?php

namespace App\Filament\Student\Resources\University\StudentPayments\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Packages\University\Enums\PaymentShortStatusEnum;

class StudentPaymentsTable
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
            ->filters([
                // SelectFilter::make('xxx_id')
                //     ->label(__('backend.xxx'))
                //     ->relationship('xxx', 'name')
                //     ->preload()
                //     ->searchable(),
            ])
            ->recordActions([
                //
                ViewAction::make()->iconButton(),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
