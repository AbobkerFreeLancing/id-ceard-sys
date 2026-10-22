<?php

namespace App\Filament\Resources\Accounting\CostCenters\Schemas;

use Packages\Accounting\Enum\AccountLevelTypeEnum;
use Packages\Accounting\Models\CostCenter;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CostCenterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make([
                            TextInput::make('name')
                                ->label(__('backend.name'))
                                ->prefixIcon(Heroicon::OutlinedInformationCircle)
                                ->maxLength(45)
                                ->required(),
                            Select::make('parent_id')
                                ->label(__('backend.parent_account'))
                                ->options(CostCenter::group()->pluck('name', 'id'))
                                ->live(debounce: 1000)
                                ->required(fn(Get $get) => $get('level_type') === AccountLevelTypeEnum::Sub->value)
                                ->searchable(),
                            Radio::make('level_type')
                                ->label(__('backend.account_level_type'))
                                ->inline(true)
                                ->required()
                                ->options(AccountLevelTypeEnum::getOptions())
                                ->live(debounce: 1000)
                                ->visibleOn('create'),
                        ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make(__('backend.extra_info'))
                        ->compact()
                        ->schema([
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(CostCenter $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?CostCenter $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(CostCenter $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?CostCenter $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
