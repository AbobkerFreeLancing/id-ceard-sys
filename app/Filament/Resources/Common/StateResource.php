<?php

namespace App\Filament\Resources\Common;

use Filament\Forms;
use Filament\Tables;
use App\Models\State;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Common\StateResource\Pages;
use App\Filament\Resources\Common\StateResource\Pages\EditState;
use App\Filament\Resources\Common\StateResource\Pages\ListStates;
use App\Filament\Resources\Common\StateResource\RelationManagers;
use App\Filament\Resources\Common\StateResource\Pages\CreateState;
use App\Filament\Resources\Common\StateResource\RelationManagers\RegionsRelationManager;
use Filament\Tables\Columns\ToggleColumn;

class StateResource extends Resource
{
    protected static ?string $model = State::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-globe-americas';

    public static function getNavigationGroup(): string
    {
        return __('backend.settings');
    }

    public static function getLabel(): ?string
    {
        return __('backend.state');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.states');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.states'));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('settings_management');
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
            //
            TextInput::make('name')->label(__('backend.name'))->required()->unique(ignoreRecord: true)->maxLength(50),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                ToggleColumn::make('is_enabled')->label(__('backend.is_enabled')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                //
                EditAction::make()->iconButton(),
                ActionGroup::make([
                    //
                    DeleteAction::make()->hidden(),
                ]),
            ])
            ->toolbarActions([])
            ->emptyStateActions([]);
    }

    public static function getRelations(): array
    {
        return [RegionsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStates::route('/'),
            'create' => CreateState::route('/create'),
            'edit' => EditState::route('/{record}/edit'),
        ];
    }
}
