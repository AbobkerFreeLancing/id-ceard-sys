<?php

namespace App\Filament\Resources\University\Divisions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Packages\University\Models\Department;
use Packages\University\Models\Division;

class DivisionForm
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
                                Select::make('department_id')
                                    ->label(__('backend.department'))
                                    ->relationship(
                                        'department',
                                        'name',
                                        modifyQueryUsing: fn($query) => $query->where('is_active', true),
                                    )
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->live(debounce: 1000)
                                    ->afterStateUpdated(function (Get $get, $set, $state) {
                                        if (!is_null($get('department_id'))) {
                                            $set('name', 'تخصص ' . Department::find($state)->name);
                                        }
                                    }),
                                TextInput::make('name')
                                    ->label(__('backend.name'))
                                    ->maxLength(80)
                                    ->unique(ignoreRecord: true),
                                TextInput::make('name_en')->label(__('backend.name_en'))->maxLength(80)->required(),
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
                                ->state(fn(Division $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Division $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(Division $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?Division $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
