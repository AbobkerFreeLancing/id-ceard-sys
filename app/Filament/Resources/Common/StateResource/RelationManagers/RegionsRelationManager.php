<?php

namespace App\Filament\Resources\Common\StateResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class RegionsRelationManager extends RelationManager
{
    protected static string $relationship = 'regions';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('backend.regions');
    }

    public static function modelLabel(): ?string
    {
        return __("backend.regions");
    }

    protected static function getPluralModelLabel(): string
    {
        return __("backend.regions");
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
                TextInput::make('name')->label(__('backend.name'))->required()->maxLength(60),
                Toggle::make('is_enabled')->label(__('backend.is_enabled'))->inline(false)->default(true)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                TextColumn::make('state.name')->label(__('backend.state')),
                IconColumn::make('is_enabled')->label(__('backend.is_enabled'))->boolean()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                ActionGroup::make([
                    DeleteAction::make()
                ])
            ])
            ->toolbarActions([

            ]);
    }
}
