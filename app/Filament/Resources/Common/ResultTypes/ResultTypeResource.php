<?php

namespace App\Filament\Resources\Common\ResultTypes;

use App\Filament\Resources\Common\ResultTypes\Pages\ManageResultTypes;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Packages\University\Models\ResultType;

class ResultTypeResource extends Resource
{
    protected static ?string $model = ResultType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string
    {
        return __('backend.settings');
    }

    public static function getLabel(): ?string
    {
        return __('backend.result_type');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.result_types');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.result_types');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('settings_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('settings_management');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            //
            TextInput::make('name')->label(__('backend.name'))->required()->maxLength(50),
            TextInput::make('name_en')->label(__('backend.name_en'))->maxLength(50),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                //
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                TextColumn::make('name_en')->label(__('backend.name_en')),
                ToggleColumn::make('is_active')->label(__('backend.is_active')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                //
                EditAction::make()->iconButton(),
                DeleteAction::make()->hidden(),
            ])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageResultTypes::route('/'),
        ];
    }
}
