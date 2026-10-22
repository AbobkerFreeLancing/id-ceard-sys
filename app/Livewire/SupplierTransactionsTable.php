<?php

namespace App\Livewire;

use Livewire\Component;
use Packages\Accounting\Models\Transaction;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;

class SupplierTransactionsTable extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithTable;
    use InteractsWithActions;
    use InteractsWithForms;

    public $record;

    public function table(Table $table): Table
    {
        return $table
            ->query(Transaction::query()->where('account_id', $this->record->account->id)->latest())
            ->columns([
                TextColumn::make('account.name')->label(__('backend.account')),
                TextColumn::make('statement')->label(__('backend.statement')),
                TextColumn::make('invoice_number')->label(__('backend.invoice_number')),
                TextColumn::make('debit')
                    ->label(__('backend.debit'))
                    ->formatStateUsing(fn($state) => number_format($state, 2)),
                TextColumn::make('credit')
                    ->label(__('backend.credit'))
                    ->formatStateUsing(fn($state) => number_format($state, 2)),
                TextColumn::make('balance')
                    ->label(__('backend.balance'))
                    ->formatStateUsing(fn($state) => number_format($state, 2)),
                TextColumn::make('notes')->label(__('backend.notes'))->wrap(),
                TextColumn::make('created_at')->label(__('backend.date')),
            ])
            ->filters([
                // ...
            ])
            ->paginationPageOptions([10, 20, 30, 'all'])
            ->recordActions([
                // ...
            ])
            ->toolbarActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.supplier-transactions-table');
    }
}
