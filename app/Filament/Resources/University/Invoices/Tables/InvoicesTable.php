<?php

namespace App\Filament\Resources\University\Invoices\Tables;

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

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ref_number')->label(__('backend.ref_number'))->searchable(),
                TextColumn::make('payment_status')
                    ->formatStateUsing(fn($state) => $state->getLabel())
                    ->badge()
                    ->color('gray')
                    ->label(__('backend.payment_status')),
                TextColumn::make('student.name')->label(__('backend.student')),
                TextColumn::make('amount')->label(__('backend.amount')),
                TextColumn::make('created_at')->label(__('backend.created_at')),
            ])
            ->filters([
                // SelectFilter::make('xxx_id')
                //     ->label(__('backend.xxx'))
                //     ->relationship('xxx', 'name')
                //     ->preload()
                //     ->searchable(),
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                ActionGroup::make([DeleteAction::make()]),
            ])
            ->toolbarActions([BulkActionGroup::make([])]);
    }
}
