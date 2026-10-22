<?php

namespace App\Filament\Resources\University\AbsenceTypes;

use App\Filament\Resources\University\AbsenceTypes\Pages\ManageAbsenceTypes;
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
use Packages\University\Models\AbsenceType;

class AbsenceTypeResource extends Resource
{
    protected static ?string $model = AbsenceType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string
    {
        return __('backend.settings');
    }

    public static function getLabel(): ?string
    {
        return __('backend.absence_type');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.absence_types');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.absence_types');
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
        return $schema
            ->components([
                //
                TextInput::make('name')->label(__('backend.name'))->required()->maxLength(60)->visibleOn('create'),
                TextInput::make('name_en')->label(__('backend.name_en'))->required()->maxLength(50),
                TextInput::make('code')->label(__('backend.code'))->required()->maxLength(30)->visibleOn('create'),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                //
                TextColumn::make('name')->label(__('backend.name')),
                ToggleColumn::make('is_enabled')->label(__('backend.is_enabled')),
                TextColumn::make('name_en')->label(__('backend.name_en')),
                TextColumn::make('code')->label(__('backend.code')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                //
                EditAction::make()->modalWidth('lg'),
                DeleteAction::make()->hidden(),
            ])
            ->toolbarActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAbsenceTypes::route('/'),
        ];
    }
}
