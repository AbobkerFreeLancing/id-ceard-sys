<?php

namespace App\Filament\Resources\Accounting;

use App\Filament\Resources\Accounting\BankResource\Pages\ListBanks;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Packages\Accounting\Models\Bank;
use Packages\Helpers\BedayaHelper;

class BankResource extends Resource
{
    protected static ?string $model = Bank::class;

    protected static bool $isScopedToTenant = false;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office';

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): string
    {
        return __('backend.financial_accounts');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
        // return auth()->user()->can('bank_management');
    }

    public static function getLabel(): ?string
    {
        return __('backend.bank');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.banks');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.banks'));
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('bank_management');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('bank_management');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('bank_management');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('backend.name'))
                    ->unique(ignoreRecord: true)
                    ->maxLength(80)
                    ->required(),
                TextInput::make('name_en')->label(__('backend.name_en'))->maxLength(80),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order', 'ASC')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('sort_order')->label(__('backend.sort_order')),
                TextColumn::make('name')
                    ->label(__('backend.name'))
                    ->searchable()
                    ->description(fn($record) => $record->name_en),
                TextColumn::make('api_key')
                    ->label(__('backend.api_key'))
                    ->copyable()
                    ->copyableState(fn(string $state): string => $state)
                    ->formatStateUsing(function ($state) {
                        if (blank($state)) {
                            return null;
                        }

                        if (mb_strlen($state) <= 7) {
                            return $state;
                        }

                        return mb_substr($state, 0, 4) . '*****' . mb_substr($state, -3);
                    }),
                TextColumn::make('code')->label(__('backend.code')),
                ToggleColumn::make('is_active')->label(__('backend.is_active'))->grow(false),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->iconButton()->modalWidth('lg'),
                ActionGroup::make([
                    //
                    Action::make('api_key_gen')
                        ->label(__('backend.api_key_gen'))
                        ->icon(Heroicon::OutlinedKey)
                        ->color('danger')
                        ->requiresConfirmation()
                        ->schema([
                            Group::make([
                                //
                                TextEntry::make('name')->label(__('backend.bank'))->inlineLabel(),
                            ])->columns(1),
                        ])
                        ->action(function ($record, $data) {
                            $record->update([
                                'api_key' => strtoupper($record->code) . BedayaHelper::APIKey(),
                            ]);
                        }),
                    DeleteAction::make()->hidden(),
                ]),
            ])
            ->toolbarActions([]);
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
            'index' => ListBanks::route('/'),
            // 'create' => Pages\CreateBank::route('/create'),
            // 'edit' => Pages\EditBank::route('/{record}/edit'),
        ];
    }
}
