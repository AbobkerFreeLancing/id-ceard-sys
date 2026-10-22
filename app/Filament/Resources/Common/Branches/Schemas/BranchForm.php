<?php

namespace App\Filament\Resources\Common\Branches\Schemas;

use Packages\Common\Models\Branch;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class BranchForm
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
                                ->maxLength(25)
                                ->required(),
                            TextInput::make('phone')
                                ->label(__('backend.phone'))
                                ->prefixIcon(Heroicon::OutlinedPhone)
                                ->length(10)
                                ->tel(),
                            TextInput::make('address')
                                ->label(__('backend.address'))
                                ->prefixIcon(Heroicon::OutlinedHome)
                                ->maxLength(100)
                                ->columnSpanFull(),
                        ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make(__('backend.extra_info'))
                        ->compact()
                        ->schema([
                            TextInput::make('slug')
                                ->label(__('backend.slug'))
                                ->unique(ignoreRecord: true)
                                ->extraAttributes(['class' => 'ltr'])
                                ->prefixIcon(Heroicon::OutlinedLink)
                                ->maxLength(80)
                                ->columnSpanFull()
                                ->required(),
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(Branch $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Branch $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(Branch $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?Branch $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
