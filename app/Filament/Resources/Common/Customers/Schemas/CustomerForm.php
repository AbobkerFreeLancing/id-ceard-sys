<?php

namespace App\Filament\Resources\Common\Customers\Schemas;

use App\Models\Setting;
use App\Models\User;
use Packages\Accounting\Models\Currency;
use Packages\Enum\Profile\UserTypeEnum;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make()
                            ->compact()
                            // ->relationship('user')
                            ->schema([
                                Hidden::make('type')->default(UserTypeEnum::Customer->value),
                                TextInput::make('name')
                                    ->label(__('backend.name'))
                                    ->prefixIcon(Heroicon::OutlinedUser)
                                    ->maxLength(45)
                                    ->required(),
                                Select::make('currency_id')
                                    ->visibleOn('create')
                                    ->required()
                                    ->dehydrated(false)
                                    ->options(Currency::where('is_enabled', 1)->get()->pluck('name', 'id'))
                                    ->default(Setting::find(1)?->currency_id)
                                    ->label(__('backend.the_currency')),
                                TextInput::make('email')
                                    ->label(__('backend.email'))
                                    ->prefixIcon(Heroicon::OutlinedEnvelope)
                                    ->email()
                                    ->unique(table: User::class, column: 'email'),
                                TextInput::make('phone')
                                    ->label(__('backend.phone'))
                                    ->prefixIcon(Heroicon::OutlinedPhone)
                                    ->tel()
                                    ->maxLength(10)
                                    ->unique(table: User::class, column: 'phone'),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make(__('backend.extra_info'))
                        ->compact()
                        ->schema([
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(fn(Model $record): ?string => $record->created_at?->diffForHumans())
                                ->hidden(fn(?Model $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(fn(Model $record): ?string => $record->updated_at?->diffForHumans())
                                ->hidden(fn(?Model $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }
}
