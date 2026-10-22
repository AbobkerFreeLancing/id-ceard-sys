<?php

namespace App\Filament\Resources\Accounting\Transactions\Schemas;

use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;

class TransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        Section::make()
                            ->columns(2)
                            ->compact()
                            ->schema([
                                TextEntry::make('account.name')
                                    ->label(__('backend.account'))
                                    ->icon(Heroicon::OutlinedBuildingOffice2),
                                TextEntry::make('ref_number')
                                    ->label(__('backend.ref_number'))
                                    ->icon(Heroicon::OutlinedInformationCircle),
                                TextEntry::make('amount')
                                    ->label(__('backend.amount'))
                                    ->formatStateUsing(fn($state) => number_format($state, 0))
                                    ->icon(Heroicon::OutlinedCreditCard),
                                TextEntry::make('statement')
                                    ->label(__('backend.statement')),
                                TextEntry::make('credit')
                                    ->label(__('backend.credit'))
                                    ->formatStateUsing(fn($state) => number_format($state, 0)),
                                TextEntry::make('debit')
                                    ->label(__('backend.debit'))
                                    ->formatStateUsing(fn($state) => number_format($state, 0)),
                                TextEntry::make('notes')
                                    ->label(__('backend.notes')),
                            ])
                    ]),
                Group::make()->schema([
                    Section::make(__('backend.extra_info'))
                        ->compact()
                        ->schema([
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn($record): ?string => $record->created_at?->format('Y-m-d H:i:s')),
                        ])
                ]),
            ])->columns(3);
    }
}
