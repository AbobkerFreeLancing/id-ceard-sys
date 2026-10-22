<?php

namespace App\Filament\Resources\Accounting;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\Accounting\FinancialYearResource\Pages\ListFinancialYears;
use App\Filament\Resources\Accounting\FinancialYearResource\Pages\CreateFinancialYear;
use App\Filament\Resources\Accounting\FinancialYearResource\Pages\EditFinancialYear;
use App\Filament\Resources\Accounting\FinancialYearResource\Pages;
use App\Filament\Resources\Accounting\FinancialYearResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Packages\Accounting\Models\FinancialYear;
use Filament\Actions\ActionGroup;

class FinancialYearResource extends Resource
{
    protected static ?string $model = FinancialYear::class;

    protected static bool $isScopedToTenant = false;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-flag';

    protected static ?int $navigationSort = 7;

    public static function getNavigationGroup(): string
    {
        return __('backend.financial_accounts');
    }

    public static function shouldRegisterNavigation(): bool
    {
        // return auth()->user()->can('financial_years_management') && config('bedaya.accounting_enabled');
        return false;
    }

    public static function getLabel(): ?string
    {
        return __('backend.financial_year');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.financial_years');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.financial_years'));
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('financial_years_management');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('financial_years_management');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('financial_years_management');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()
                ->schema([
                    TextInput::make('name')->label(__('backend.name'))->maxLength(15)->required(),
                    DatePicker::make('start_date')->label(__('backend.start_date'))->required(),
                    Toggle::make('is_closed')->label(__('backend.is_closed'))->inline(false)->default(false),
                ])
                ->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                TextColumn::make('start_date')->date()->label(__('backend.start_date'))->searchable(),
                IconColumn::make('is_closed')->label(__('backend.is_closed'))->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([EditAction::make()->iconButton(), ActionGroup::make([DeleteAction::make()])])
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
            'index' => ListFinancialYears::route('/'),
            'create' => CreateFinancialYear::route('/create'),
            'edit' => EditFinancialYear::route('/{record}/edit'),
        ];
    }
}
