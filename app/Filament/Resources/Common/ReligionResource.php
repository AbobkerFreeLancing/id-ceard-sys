<?php

namespace App\Filament\Resources\Common;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\ActionGroup;
use Packages\Common\Models\Religion;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Common\ReligionResource\Pages;
use App\Filament\Resources\Common\ReligionResource\RelationManagers;
use App\Filament\Resources\Common\ReligionResource\Pages\ManageReligions;

class ReligionResource extends Resource
{
    protected static ?string $model = Religion::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-scale';

    public static function getNavigationGroup(): string
    {
        return __('backend.settings');
    }

    public static function shouldRegisterNavigation(): bool
    {
        // return auth()->user()->can('settings_management');
        return false;
    }

    public static function getLabel(): ?string
    {
        return __('backend.religion');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.religions');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.religions'));
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('settings_management');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('settings_management');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('settings_management');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label(__('backend.name'))->required()->maxLength(50),
            Toggle::make('is_enabled')->label(__('backend.is_enabled'))->default(true)->inline(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                IconColumn::make('is_enabled')->label(__('backend.is_enabled'))->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([EditAction::make()->iconButton(), ActionGroup::make([DeleteAction::make()])])
            ->toolbarActions([])
            ->emptyStateActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageReligions::route('/'),
        ];
    }
}
