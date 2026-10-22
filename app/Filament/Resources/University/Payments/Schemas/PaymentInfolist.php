<?php

namespace App\Filament\Resources\University\Payments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Packages\University\Models\Payment;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make()
                            ->compact()
                            ->schema([
                                //
                                TextEntry::make('amount')
                                    ->label(__('backend.amount'))
                                    ->formatStateUsing(
                                        fn($state, $record) => number_format($state, 0) .
                                            ' ' .
                                            $record?->currency?->symbol,
                                    ),
                                TextEntry::make('ref_number')->label(__('backend.ref_number')),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make()
                        ->compact()
                        ->schema([
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(Payment $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Payment $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
