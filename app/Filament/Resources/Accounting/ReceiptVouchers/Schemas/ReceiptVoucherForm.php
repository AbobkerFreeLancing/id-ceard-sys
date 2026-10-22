<?php

namespace App\Filament\Resources\Accounting\ReceiptVouchers\Schemas;

use Packages\Accounting\Enum\AccountLevelTypeEnum;
use Packages\Accounting\Models\Account;
use Packages\Accounting\Models\PaymentMethod;
use Packages\Accounting\Models\ReceiptVoucher;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class ReceiptVoucherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make([
                            TextInput::make('amount')->label(__('backend.amount'))->minValue(1)->numeric()->required(),
                            Select::make('currency_id')
                                ->label(__('backend.the_currency'))
                                ->live(debounce: 1000)
                                ->relationship('currency', 'name', fn(Builder $query) => $query->where('is_enabled', 1))
                                ->required()
                                ->default(fn() => getMainCurrency()?->id),

                            Select::make('giver_account_id')
                                ->label(__('backend.revenue_account'))
                                ->disabled(function ($get) {})
                                ->options(function (Get $get) {
                                    return Account::where('level_type', AccountLevelTypeEnum::Sub->value)
                                        ->where('type', 'credit')
                                        ->where('currency_id', $get('currency_id'))
                                        // ->where('parent_id', 4)
                                        ->get()
                                        ->pluck('name_balance', 'id');
                                })
                                ->required(),
                            Select::make('receiver_account_id')
                                ->label(__('backend.safe_account'))
                                ->disabled(fn($get) => $get('currency_id') == null)
                                ->options(function (Get $get) {
                                    return Account::where('level_type', AccountLevelTypeEnum::Sub->value)
                                        ->whereIn('slug', ['safe_account', 'bank_account'])
                                        ->where('currency_id', $get('currency_id'))
                                        ->get()
                                        ->pluck('name_balance', 'id');
                                })
                                ->required(),
                            Select::make('payment_method_id')
                                ->hidden()
                                ->label(__('backend.the_payment_method'))
                                ->options(PaymentMethod::all()->pluck('name', 'id'))
                                ->required(),
                            DatePicker::make('receipt_date')
                                ->label(__('backend.date'))
                                ->required()
                                ->native(false)
                                ->default(now()),
                        ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make(__('backend.extra_info'))
                        ->compact()
                        ->schema([
                            TextInput::make('receiver_name')->label(__('backend.receiver_name'))->maxLength(85),
                            Textarea::make('notes')
                                ->label(__('backend.statement'))
                                ->rows(2)
                                ->columnSpan('full')
                                ->maxLength(200),
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(ReceiptVoucher $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?ReceiptVoucher $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(ReceiptVoucher $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?ReceiptVoucher $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
