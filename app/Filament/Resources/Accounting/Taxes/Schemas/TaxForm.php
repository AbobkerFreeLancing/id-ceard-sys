<?php

namespace App\Filament\Resources\Accounting\Taxes\Schemas;

use Packages\Accounting\Models\Tax;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TaxForm
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
                                ->unique(ignoreRecord: true)
                                ->minLength(3)
                                ->maxLength(45)
                                ->required()
                                ->disabled(fn($record) => !$record->is_editable),
                            TextInput::make('amount')
                                ->label(__('backend.value'))
                                ->numeric()
                                ->required()
                                ->extraInputAttributes(['step' => '0.01'])
                                ->minValue(0)
                                ->maxValue(100),
                            // Select::make('type')->label(__('backend.type'))->required()->default('percentage')
                            // ->options([
                            //     'percentage' => __('backend.percentage'),
                            //     'value' => __('backend.value'),
                            // ]),
                        ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make(__('backend.extra_info'))
                        ->compact()
                        ->schema([
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(Tax $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Tax $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(Tax $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?Tax $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
