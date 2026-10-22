<?php

namespace App\Filament\Resources\Accounting\Safes\Schemas;

use Packages\Accounting\Models\Account;
use Packages\Enum\Accounting\SafeBankTypeEnum;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class SafeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make([
                            Radio::make('account_type')
                                ->label(__('backend.account_type'))
                                ->required()
                                ->options(SafeBankTypeEnum::getOptions())
                                ->inline(true)
                                ->default(SafeBankTypeEnum::Safe->value)
                                ->live(debounce: 1000)
                                ->disabledOn('edit'),
                            TextInput::make('name')->label(ucfirst(__('backend.name')))->maxLength(45)->required(),
                            Select::make('bank_id')
                                ->label(__('backend.bank'))
                                ->relationship('bank', 'name', fn(Builder $query) => $query->where('is_enabled', true))
                                ->preload()
                                ->searchable()
                                ->disabledOn('edit')
                                ->visible(fn(Get $get) => $get('account_type') == SafeBankTypeEnum::Bank->value)
                                ->required(fn(Get $get) => $get('account_type') == SafeBankTypeEnum::Bank->value),
                            Select::make('currency_id')
                                ->label(__('backend.the_currency'))
                                ->relationship(
                                    'currency',
                                    'name',
                                    fn(Builder $query) => $query->where('is_enabled', true),
                                )
                                ->default(fn() => getMainCurrency()->id)
                                ->visible(fn($livewire) => $livewire instanceof CreateRecord)
                                ->required(),
                            TextInput::make('start_balance')
                                ->label(ucfirst(__('backend.start_balance')))
                                ->visibleOn('create')
                                ->numeric()
                                ->default(0)
                                ->required(),
                        ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make(__('backend.extra_info'))
                        ->compact()
                        ->schema([
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(Account $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Account $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(Account $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?Account $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
