<?php

namespace App\Filament\Resources\Common\Settings\Schemas;

use App\Filament\Resources\Accounting\Currencies\CurrencyResource;
use Packages\Accounting\Models\Currency;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Schema as DBSchema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Tabs::make('dd')->tabs([
                            Tab::make('global_settings')
                                ->label(__('backend.global_settings'))
                                ->icon('heroicon-o-cog-6-tooth')
                                ->schema([
                                    TextInput::make('company_name')
                                        ->required()
                                        ->label(__('backend.company_name'))
                                        ->maxLength(100),

                                    TextInput::make('tagline')->label(__('backend.tagline'))->hidden()->maxLength(100),

                                    TextInput::make('company_address')->label(__('backend.address'))->maxLength(100),

                                    TextInput::make('company_phones')->label(__('backend.phones'))->maxLength(100),

                                    TextInput::make('company_email')
                                        ->email()
                                        ->label(__('backend.email'))
                                        ->maxLength(100),

                                    TextInput::make('invoice_tagline')
                                        ->required()
                                        ->label(__('backend.invoice_tagline'))
                                        ->maxLength(150),

                                    Select::make('currency_id')
                                        ->options(Currency::where('is_enabled', 1)->get()->pluck('name', 'id'))
                                        ->label(__('backend.main_currency'))
                                        ->visible(config('bedaya.accounting_enabled'))
                                        ->required(),
                                ])
                                ->columns(2),
                            Tab::make('app_settings')
                                ->hidden()
                                ->label(__('backend.app_settings'))
                                ->icon('heroicon-o-cog-6-tooth')
                                ->schema([
                                    Toggle::make('pause_api_login')->label(__('backend.pause_login')),
                                    Toggle::make('pause_api_register')->label(__('backend.pause_register')),
                                ])
                                ->columns(2),
                        ]),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make(__('backend.settings_extra'))
                        ->compact()
                        ->extraAttributes(['class' => 'gap-2 xxxxxx'])
                        ->schema([
                            Action::make('currencies')
                                ->label(__('backend.currencies'))
                                ->icon(Heroicon::CurrencyDollar)
                                ->color('gray')
                                ->url(CurrencyResource::getUrl('index'))
                                ->outlined()
                                ->visible(
                                    fn() => auth()->user()->can('currency_management') &&
                                        config('bedaya.multi_currencies_enabled'),
                                )
                                ->extraAttributes(['class' => 'w-full']),
                            
                        ])
                        ->columns(1),
                ]),
            ])
            ->columns(3);
    }
}
