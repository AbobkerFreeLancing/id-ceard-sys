<?php

namespace App\Filament\Resources\Common\Customers\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerSalesRelationManager extends RelationManager
{
    protected static string $relationship = 'sales';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('backend.sales');
    }

    public static function modelLabel(): ?string
    {
        return __("backend.sale_invoice");
    }

    protected static function getPluralModelLabel(): string
    {
        return __("backend.sales");
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required()->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ref_number')->label(__('#')),
                TextColumn::make('customer.user.name')->label(__('backend.the_customer')),
                // TextColumn::make('profit_percentage')->label(__('backend.profit_percentage'))->suffix('%'),
                TextColumn::make('total')->formatStateUsing(function($state) { return number_format($state,2);})->label(__('backend.total')),
                TextColumn::make('payment_status')->label(__('backend.payment_status'))->icon('heroicon-o-currency-dollar')
                ->color(function($record) {
                    if($record->payment_status_label == 'not_paid') {
                        return 'danger';
                    }
                    elseif ($record->payment_status_label == 'partially_paid') {
                        return 'warning';
                    }
                    elseif ($record->payment_status_label == 'fully_paid') {
                        return 'success';
                    }
                }),
                IconColumn::make('is_approved')->boolean()->label(__('backend.approved')),
                TextColumn::make('created_at')->label(__('backend.created_at'))
            ])
            ->filters([
                Filter::make('created_at')
                ->schema([
                    DatePicker::make('created_from')->label(__('backend.from_date')),
                    DatePicker::make('created_until')->label(__('backend.to_date'))->default(now()),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                }),
                SelectFilter::make('warehouse')->relationship('warehouse', 'name')->label(__('backend.store'))->multiple(),
            ])
            ->headerActions([
            ])
            ->recordActions([
            ])
            ->toolbarActions([]);
    }
}
