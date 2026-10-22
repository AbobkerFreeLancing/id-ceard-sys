<?php

namespace App\Filament\Resources\Common\Countries\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\ToggleColumn;

class CityRelationManager extends RelationManager
{
    protected static string $relationship = 'cities';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('backend.cities');
    }

    public static function modelLabel(): ?string
    {
        return __("backend.cities");
    }

    protected static function getPluralModelLabel(): string
    {
        return __("backend.cities");
    }

    protected function canCreate(): bool
    {
        return auth()->user()->can('settings_management');
    }

    protected function canEdit(Model $record): bool
    {
        return auth()->user()->can('settings_management');
    }

    protected function canDelete(Model $record): bool
    {
        return auth()->user()->can('settings_management');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('backend.name'))
                    ->required()
                    ->maxLength(60),
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')->label(__('backend.name')),
                ToggleColumn::make('is_enabled')->label(__('backend.is_enabled'))
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                ->modalWidth('lg')
            ])
            ->recordActions([
                EditAction::make()
                ->modalWidth('lg')
                ->iconButton(),
                ActionGroup::make([
                    DeleteAction::make()
                ])
            ])
            ->toolbarActions([]);
    }
}
