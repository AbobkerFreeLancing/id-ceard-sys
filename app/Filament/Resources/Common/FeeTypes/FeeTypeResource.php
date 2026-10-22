<?php

namespace App\Filament\Resources\Common\FeeTypes;

use App\Filament\Resources\Common\FeeTypes\Pages\ManageFeeTypes;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Packages\University\Models\FeeType;

class FeeTypeResource extends Resource
{
    protected static ?string $model = FeeType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string
    {
        return __('backend.fee_management_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.fee_type');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.fee_types');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.fee_types');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('fee_structure_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('fee_structure_management');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('name')->label(__('backend.name'))->required()->maxLength(80),
                TextInput::make('name_en')->label(__('backend.name_en'))->maxLength(80)->required(),
                // TextInput::make('code')->label(__('backend.code'))->maxLength(10)->required(),
                TextInput::make('default_amount')
                    ->label(__('backend.default_amount'))
                    ->required()
                    ->minValue(0)
                    ->numeric()
                    ->default(0.0),
                Toggle::make('is_mandatory')->label(__('backend.is_mandatory'))->default(true),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('sort_order', 'ASC')
            ->columns([
                //
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                TextColumn::make('default_amount')->label(__('backend.default_amount')),
                TextColumn::make('name_en')->label(__('backend.name_en')),
                TextColumn::make('code')->label(__('backend.code')),
                ToggleColumn::make('is_active')->label(__('backend.is_active')),
                // IconColumn::make('is_mandatory')->label(__('backend.is_mandatory'))->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                //
                EditAction::make()->iconButton()->modalWidth('2xl'),
                DeleteAction::make()->hidden(),
            ])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageFeeTypes::route('/'),
        ];
    }
}
