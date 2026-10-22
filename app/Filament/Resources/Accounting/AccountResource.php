<?php

namespace App\Filament\Resources\Accounting;

use App\Filament\Resources\Accounting\AccountResource\Pages\AccountTreeViewPage;
use App\Filament\Resources\Accounting\AccountResource\Pages\CreateAccount;
use App\Filament\Resources\Accounting\AccountResource\Pages\ListAccounts;
use App\Models\Setting;
use Packages\Accounting\Enum\AccountLevelTypeEnum;
use Packages\Accounting\Models\Account;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static bool $isScopedToTenant = false;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): string
    {
        return __('backend.financial_accounts');
    }

    public static function getLabel(): ?string
    {
        return __('backend.account');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.chart_of_accounts');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.chart_of_accounts'));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('accounts_management') && config('bedaya.accounting_enabled');
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('accounts_management') && config('bedaya.accounting_enabled');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('accounts_management');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('accounts_management');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('accounts_management') &&
            $record->is_editable &&
            $record->balance == 0 &&
            !in_array($record->slug, ['supplier', 'user']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label(ucfirst(__('backend.name')))->maxLength(100)->required(),
                Select::make('parent_id')
                    ->label(__('backend.parent_account'))
                    ->options(
                        Account::where('level_type', AccountLevelTypeEnum::Group->value)
                            ->whereNotIn('slug', ['assets', 'equity'])
                            ->pluck('name', 'id'),
                    )
                    ->live(debounce: 1000)
                    ->searchable()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $set('type', Account::find($get('parent_id'))->type);
                    }),
                Select::make('currency_id')
                    ->label(__('backend.the_currency'))
                    ->relationship('currency', 'name', fn($query) => $query->where('is_enabled', true))
                    ->required(fn($get) => $get('level_type') == AccountLevelTypeEnum::Sub->value)
                    ->visible(fn($get) => $get('level_type') == AccountLevelTypeEnum::Sub->value)
                    ->visibleOn('create'),
                Select::make('level_type')
                    ->label(__('backend.account_level_type'))
                    ->options(AccountLevelTypeEnum::getOptions())
                    ->default(AccountLevelTypeEnum::Sub->value)
                    ->required()
                    ->live(debounce: 1000)
                    ->visibleOn('create'),
                TextInput::make('start_balance')
                    ->label(ucfirst(__('backend.start_balance')))
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->visibleOn('create'),
                Radio::make('type')
                    ->options(['debit' => __('backend.debit'), 'credit' => __('backend.credit')])
                    ->label(__('backend.account_type'))
                    ->inline(true)
                    ->required(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->striped()
            ->query(Account::query()->orderBy('code', 'ASC'))
            ->columns([
                TextColumn::make('code')->label(__('backend.code')),
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                TextColumn::make('balance')
                    ->label(__('backend.balance'))
                    ->formatStateUsing(fn($record) => number_format($record->balance, 2)),
                TextColumn::make('currency.symbol')->label(__('backend.currency')),
                TextColumn::make('type_label')->label(__('backend.account_type')),
                TextColumn::make('level_type')
                    ->badge()
                    ->color(fn($record) => AccountLevelTypeEnum::from($record->level_type)->getColor())
                    ->icon(fn($record) => AccountLevelTypeEnum::from($record->level_type)->getIcon())
                    ->formatStateUsing(fn($record) => AccountLevelTypeEnum::from($record->level_type)->getLabel())
                    ->label(__('backend.account_level_type')),
                TextColumn::make('parent.name')
                    ->label(__('backend.parent_account'))
                    ->formatStateUsing(fn($state) => $state != null ? $state : '-'),
            ])
            ->filters([
                SelectFilter::make('level_type')
                    ->options(AccountLevelTypeEnum::getOptions())
                    ->label(__('backend.account_level_type')),
                SelectFilter::make('currency')->relationship('currency', 'name')->label(__('backend.the_currency')),
            ])
            ->recordActions([
                Action::make('account_movement')
                    ->modalHeading(fn($record) => $record->name . ' - ' . __('backend.account_movement'))
                    ->icon('heroicon-o-document-text')
                    ->visible(fn($record) => $record->level_type == AccountLevelTypeEnum::Sub->value)
                    ->slideOver()
                    ->color(Color::Gray)
                    ->modalContent(
                        fn(Account $record) => view('bedaya:accounting::view-account-movements', ['record' => $record]),
                    )
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->label(__('backend.account_movement')),
                EditAction::make()
                    ->iconButton()
                    ->modalWidth(Width::Large)
                    ->visible(function ($record) {
                        return $record->is_editable;
                    }),
                ActionGroup::make([
                    DeleteAction::make()->hidden(function ($record) {
                        return $record->level_type == AccountLevelTypeEnum::Group->value;
                    }),
                ]),
            ])
            ->toolbarActions([
                BulkAction::make('change_to_main_currency')
                    ->label(__('backend.change_to_main_currency'))
                    ->requiresConfirmation()
                    ->color(Color::Red)
                    ->action(function (Collection $records) {
                        foreach ($records as $account) {
                            $account->currency_id = Setting::find(1)->currency?->id;
                            $account->save();
                        }
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAccounts::route('/'),
            'tree' => AccountTreeViewPage::route('/tree'),
            // 'create' => CreateAccount::route('/create'),
            // 'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}
