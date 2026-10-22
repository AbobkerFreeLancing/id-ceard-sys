<?php

namespace App\Filament\Resources\DocsModule\Projects\Schemas;

use Packages\DocsModule\Models\Project;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->schema([
                    Section::make([
                        TextInput::make('name')
                            ->label(__('backend.name'))
                            ->prefixIcon(Heroicon::OutlinedInformationCircle)
                            ->maxLength(100)
                            ->columnSpanFull()
                            ->required(),
                        TextInput::make('base_api_url')
                            ->label(__('backend.base_api_url'))
                            ->prefixIcon(Heroicon::OutlinedLink)
                            ->url()
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label(__('backend.description'))
                            ->rows(3)
                            ->columnSpanFull()
                            ->maxLength(300),
                    ])->columns(2)
                ])->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make(__('backend.extra_info'))
                        ->compact()
                        ->schema([
                            TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->columnSpanFull()
                            ->maxLength(85),
                            TextEntry::make('created_at')->label(__('backend.created_at'))
                                ->state(fn(Project $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Project $record) => $record === null),
                            TextEntry::make('updated_at')->label(__('backend.updated_at'))
                                ->state(fn(Project $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?Project $record) => $record === null),
                        ])
                ]),
            ])->columns(3);
    }
}
