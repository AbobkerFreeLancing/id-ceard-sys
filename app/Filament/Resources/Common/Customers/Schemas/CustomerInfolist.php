<?php

namespace App\Filament\Resources\Common\Customers\Schemas;

use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class CustomerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    TextEntry::make('user.name')
                        ->label(__('backend.name')),
                    TextEntry::make('user.account.balance')
                        ->label(__('backend.balance'))
                        ->badge()
                        ->color(Color::Orange),
                    TextEntry::make('sales_count')
                        ->label(__('backend.sales'))
                        ->counts('sales')
                        ->badge()
                        ->color(Color::Blue),
                    TextEntry::make('sales_total')
                        ->label(__('backend.sales_total_stats'))
                        ->badge()
                        ->color(Color::Blue),
                    TextEntry::make('created_at')
                        ->label(__('backend.created_at'))
                        ->date(),
                ])->columns(4)
            ]);
    }
}
