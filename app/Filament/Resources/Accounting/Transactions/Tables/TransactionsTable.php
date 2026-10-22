<?php

namespace App\Filament\Resources\Accounting\Transactions\Tables;

use App\Filament\Pages\TransactionReportsPage;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component as Livewire;
use pxlrbt\FilamentExcel\Actions\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('amount')->label(__('backend.amount'))
                    ->formatStateUsing(fn($state) => number_format($state, 2)),
                // TextColumn::make('ref_number')->label(__('backend.ref_number'))->searchable(),
                TextColumn::make('account.name')->label(__('backend.account')),
                TextColumn::make('created_at')->label(__('backend.date'))->sortable(),
                TextColumn::make('statement')->label(__('backend.statement')),
                TextColumn::make('invoice_number')->label(__('backend.invoice_number')),
                TextColumn::make('debit')->label(__('backend.debit'))->formatStateUsing(fn($state) => number_format($state, 2)),
                TextColumn::make('credit')->label(__('backend.credit'))->formatStateUsing(fn($state) => number_format($state, 2)),
                TextColumn::make('balance')->label(__('backend.balance'))->formatStateUsing(fn($state) => number_format($state, 2)),
                TextColumn::make('notes')->label(__('backend.notes'))->wrap(),
                // TextColumn::make('exchange_rate')->label(__('backend.exchange_rate')),
                // TextColumn::make('exchange_rate_notes')->label(__('backend.exchange_rate_notes')),
                // TextColumn::make('type_label')->label(__('backend.type')),
            ])
            ->filters([
                SelectFilter::make('account_id')
                    ->label(__('backend.account'))
                    ->searchable()->preload()
                    ->multiple()
                    ->relationship('account', 'name', fn($query) => $query->whereHas('transactions')),
                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('created_from')->native(false)->label(__('backend.from_date')),
                        DatePicker::make('created_until')->native(false)->label(__('backend.to_date'))->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                // TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
            ])
            ->toolbarActions([
                // Action::make('reports_page')
                //     ->label(__('backend.view_and_print'))
                //     ->size('sm')->color('warning')->icon('heroicon-o-printer')
                //     ->url(function (Livewire $livewire) {
                //         return TransactionReportsPage::getUrl($livewire->getTableRecords()->items());
                //     }),
                DeleteBulkAction::make()->visible(fn() => auth()->user()->hasRole('dev')),
                ExportBulkAction::make()
                    ->size(Size::Small)
                    ->outlined()
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->exports([
                        ExcelExport::make()->withColumns([
                            Column::make('account.name'),
                            Column::make('statement'),
                            Column::make('invoice_number'),
                            Column::make('debit'),
                            Column::make('credit'),
                            Column::make('balance'),
                            Column::make('exchange_rate'),
                            Column::make('exchange_rate_notes'),
                            Column::make('notes'),
                            Column::make('created_at'),
                        ]),
                    ])
            ]);
    }
}
