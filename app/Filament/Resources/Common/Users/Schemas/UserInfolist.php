<?php

namespace App\Filament\Resources\Common\Users\Schemas;

use App\Models\User;
use Packages\Enum\Profile\UserAccountStatusEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserInfolist
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
                                TextEntry::make('name')
                                    ->label(__('backend.name'))
                                    ->icon(Heroicon::OutlinedUser),
                                TextEntry::make('email')
                                    ->label(__('backend.email'))
                                    ->icon(Heroicon::OutlinedEnvelope),
                                TextEntry::make('user.account_status')
                                    ->label(__('backend.status'))
                                    ->getStateUsing(fn($record) => UserAccountStatusEnum::from($record->account_status)->getLabel()),
                                TextEntry::make('phone')
                                    ->label(__('backend.phone'))
                                    ->icon(Heroicon::OutlinedPhone),
                            ])->columns(2)
                    ])->columnSpan(['lg' => 2]),
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
