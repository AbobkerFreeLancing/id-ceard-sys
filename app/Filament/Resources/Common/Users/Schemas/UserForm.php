<?php

namespace App\Filament\Resources\Common\Users\Schemas;

use App\Models\User;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        Section::make()
                            ->columns(2)
                            ->compact()
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('backend.name'))
                                    ->prefixIcon(Heroicon::OutlinedUser)
                                    ->maxLength(50)
                                    ->required(),
                                TextInput::make('email')
                                    ->label(__('backend.email'))
                                    ->prefixIcon(Heroicon::OutlinedEnvelope)
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                Select::make('roles')
                                    ->label(__('backend.roles_jobs'))
                                    ->required()
                                    ->relationship(
                                        name: 'roles',
                                        titleAttribute: 'description',
                                        modifyQueryUsing: fn(Builder $query) => $query->where('name', '!=', 'dev')
                                    )
                                    ->preload()
                                    ->prefixIcon(Heroicon::OutlinedBriefcase)
                                    ->multiple()
                                    ->columnSpanFull()
                                    ->maxItems(3),
                                Select::make('branches')
                                    ->label(__('backend.branches'))
                                    ->visible(config('bedaya.has_multi_branch'))
                                    ->required()
                                    ->relationship(
                                        name: 'branches',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: fn(Builder $query) => $query->where('is_enabled', true)
                                    )
                                    ->preload()
                                    ->prefixIcon(Heroicon::OutlinedBriefcase)
                                    ->multiple()
                                    ->columnSpanFull()
                                    ->maxItems(5),
                                TextInput::make('phone')
                                    ->label(__('backend.phone'))
                                    ->prefixIcon(Heroicon::OutlinedPhone)
                                    ->tel()
                                    ->maxLength(10)
                                    ->unique(ignoreRecord: true),
                            ])
                    ]),
                Group::make()->schema([
                    Section::make(__('backend.extra_info'))
                        ->compact()
                        ->schema([
                            TextEntry::make('created_at')->label(__('backend.created_at'))
                                ->state(fn(User $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?User $record) => $record === null),
                            TextEntry::make('updated_at')->label(__('backend.updated_at'))
                                ->state(fn(User $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?User $record) => $record === null),
                        ])
                ]),
            ])->columns(3);
    }
}
