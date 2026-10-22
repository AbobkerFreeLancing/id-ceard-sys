<?php

namespace App\Filament\Resources\University\FeeStructures\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class FeeStructureInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            //
            Group::make()
                ->columns(3)
                ->schema([
                    TextEntry::make('college.name')->label(__('backend.college')),
                    TextEntry::make('academicYear.name')->label(__('backend.academic_year')),
                    TextEntry::make('fees_total')
                        ->label(__('backend.fees_total'))
                        ->formatStateUsing(
                            fn($state, $record) => number_format($state, 2) . ' ' . $record?->currency?->symbol,
                        ),
                ]),
            RepeatableEntry::make('items')
                ->label(__('backend.items'))
                ->table([TableColumn::make(__('backend.fee_type')), TableColumn::make(__('backend.amount'))])
                ->columns(2)
                ->schema([
                    TextEntry::make('feeType.name')->label(__('backend.fee_type')),
                    TextEntry::make('amount')->label(__('backend.amount')),
                ]),

            Group::make()
                ->columns(3)
                ->visible()
                ->schema([
                    TextEntry::make('approvedBy.name')->label(__('backend.approved_by')),
                    TextEntry::make('approved_at')->label(__('backend.approved_at')),
                ]),
        ]);
    }
}
