<?php

namespace App\Filament\Resources\Common;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Illuminate\Notifications\Action;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Common\PermissionResource\Pages;
use App\Filament\Resources\Common\PermissionResource\RelationManagers;
use App\Filament\Resources\Common\PermissionResource\Pages\ListPermissions;
use Filament\Support\Enums\Width;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static bool $isScopedToTenant = false;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getLabel(): ?string
    {
        return __("backend.permission");
    }

    public static function getPluralLabel(): ?string
    {
        return __("backend.permissions");
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__("backend.permissions"));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationGroup(): string
    {
        return __("backend.users_module");
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->unique(ignorable: fn(?Model $record): ?Model => $record)
                    ->required()
                    ->maxLength(100),
                TextInput::make('label_ar')
                    ->label(__('backend.title_ar'))
                    ->unique(ignorable: fn(?Model $record): ?Model => $record)
                    ->required()
                    ->maxLength(100),
                TextInput::make('label')
                    ->label(__('backend.title'))
                    ->unique(ignorable: fn(?Model $record): ?Model => $record)
                    ->required()
                    ->maxLength(100),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated([50, 70])
            ->columns([
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                TextColumn::make('label_ar')->label(__('backend.title_ar'))->searchable(),
                TextColumn::make('label')->label(__('backend.title'))->searchable(),
                TextColumn::make('created_at')->label(__('backend.created_at'))->sortable()

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->iconButton()
                    ->modalWidth(Width::Small),
                ActionGroup::make([
                    DeleteAction::make()
                ])
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
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
            'index' => ListPermissions::route('/'),
            // 'create' => Pages\CreatePermission::route('/create'),
            // 'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }
}
