<?php

namespace App\Filament\Resources\Accounting\Expenses\Schemas;

use Packages\Accounting\Enum\AccountLevelTypeEnum;
use Packages\Accounting\Models\Account;
use Packages\Accounting\Models\Expense;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make([
                            Select::make('account_id')
                                ->label(__('backend.expense_type'))
                                ->options(
                                    Account::whereHas('parent', function ($q) {
                                        return $q->where('slug', 'acc_administrative_expenses');
                                    })->pluck('name', 'id'),
                                )
                                ->required()
                                ->preload()
                                ->searchable(),

                            Select::make('payment_account_id')
                                ->label(__('backend.safe_and_bank_account'))
                                ->live(debounce: 1000)
                                ->options(function (Get $get) {
                                    return Account::where('level_type', AccountLevelTypeEnum::Sub->value)
                                        ->whereIn('slug', ['safe_account', 'bank_account'])
                                        ->get()
                                        ->mapWithKeys(function ($account) {
                                            $canViewBalance = auth()->user()->can('safe_balance_view'); // Replace with your permission check

                                            $label = $canViewBalance
                                                ? "{$account->name} - {$account->balance} {$account->currency->name}"
                                                : $account->name;

                                            return [$account->id => $label];
                                        });
                                })
                                ->suffix(
                                    fn($state, $record) => $state != null
                                        ? Account::whereId($state)->first()->currency->symbol
                                        : '',
                                )
                                ->required(),
                            TextInput::make('amount')
                                ->disabled(function ($get) {
                                    return $get('payment_account_id') == null;
                                })
                                ->label(__('backend.amount'))
                                ->minValue(1)
                                ->maxValue(function ($get) {
                                    if ($get('payment_account_id') != null) {
                                        return Account::where('id', $get('payment_account_id'))?->first()->balance;
                                    }
                                })
                                ->numeric()
                                ->required(),
                            DatePicker::make('expense_date')
                                ->label(__('backend.date'))
                                ->native(false)
                                ->required()
                                ->default(now()),
                            TextInput::make('receiver_name')->label(__('backend.receiver_name'))->maxLength(30),

                            //////////
                            Section::make()->schema([
                                Repeater::make('items')
                                    ->schema([
                                        TextInput::make('name')
                                            ->maxLength(100)
                                            ->required()
                                            ->label(__('backend.the_itemx')),
                                        TextInput::make('qty')
                                            ->numeric()
                                            ->required()
                                            ->default(1)
                                            ->label(__('backend.qty')),
                                        TextInput::make('price')->numeric()->required()->label(__('backend.price')),
                                    ])
                                    ->label(__('backend.expense_items'))
                                    ->columnSpan('full')
                                    ->defaultItems(0)
                                    ->addActionLabel(__('backend.add_more'))
                                    ->collapsible()
                                    ->columns(3)
                                    ->relationship('items'),
                            ]), // card end
                            //////////
                        ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make(__('backend.extra_info'))
                        ->compact()
                        ->schema([
                            Textarea::make('notes')
                                ->label(__('backend.statement'))
                                ->rows(2)
                                ->columnSpan('full')
                                ->maxLength(200),
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(Expense $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Expense $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(Expense $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?Expense $record) => $record === null),
                        ]),

                    Section::make()->schema([
                        FileUpload::make('attachment')
                            ->maxSize(2048)
                            ->directory('expense-attachments')
                            ->label(__('backend.receipt_sceenshot'))
                            ->maxFiles(1),
                    ]),
                ]),
            ])
            ->columns(3);
    }
}
