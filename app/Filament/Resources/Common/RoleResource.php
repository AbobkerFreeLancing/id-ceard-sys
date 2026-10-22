<?php

namespace App\Filament\Resources\Common;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Spatie\Permission\Models\Role;
use App\Rules\EnglishMixValidation;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Spatie\Permission\Models\Permission;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\Common\RoleResource\Pages;
use App\Filament\Resources\Common\RoleResource\Pages\EditRole;
use App\Filament\Resources\Common\RoleResource\Pages\ListRoles;
use App\Filament\Resources\Common\RoleResource\Pages\CreateRole;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static bool $isScopedToTenant = false;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-key';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string
    {
        return __("backend.users_module");
    }

    public static function getLabel(): ?string
    {
        return __("backend.role_job");
    }

    public static function getPluralLabel(): ?string
    {
        return __("backend.system_roles");
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__("backend.system_roles"));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('role_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('role_management');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('role_management');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('role_management');
    }

    public static function canDelete(Model $record): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label(__('backend.name'))
                    ->maxLength(50)
                    ->rules([new EnglishMixValidation])
                    ->hidden(fn($livewire) => $livewire instanceof CreateRecord)
                    ->helperText(__('backend.english_only'))
                    ->required()->unique(ignorable: fn(?Model $record): ?Model => $record),
                TextInput::make('description')
                    ->label(__('backend.description'))
                    ->required()
                    ->maxLength(65),
                Section::make()->schema([
                    CheckboxList::make('permissions')
                        ->columns(4)
                        ->bulkToggleable()
                        ->searchable()
                        ->relationship('permissions', 'label', fn($query) => $query->orderBy('name'))
                        ->descriptions(fn($record) => Permission::orderBy('name')->pluck('label_ar', 'id'))
                        ->label(ucfirst(__('backend.access_permissions')))
                ])
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->recordUrl(null)
            ->modifyQueryUsing(fn($query) => auth()->user()->hasRole('dev') ? $query->where('id', '>', 0) : $query->where('name', '!=', 'dev'))
            ->columns([
                TextColumn::make('name')
                    ->label(__('backend.name'))
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')->label(__('backend.description')),
                TextColumn::make('users_count')->counts('users')->label(__('backend.users_count')),
                TextColumn::make('created_at')->label(__('backend.created_at'))->date(),
            ])
            ->recordActions([
                EditAction::make()->iconButton()
                    ->visible(fn($record) => (auth()->user()->can('role_management')
                        && !in_array($record->name, ['admin', 'dev','employee_non']))),
                ActionGroup::make([
                    DeleteAction::make()
                        ->requiresConfirmation()
                        ->visible(fn($record) => (auth()->user()->can('role_management')
                            && !in_array($record->name, ['admin', 'dev','employee_non'])))
                        ->modalHeading(fn($record) => __('backend.action_delete') . " " . $record->name),
                ])
            ])
            ->filters([])
            ->filtersTriggerAction(
                fn(Action $action) => $action
                    ->button()
                    ->label(__('backend.filters')),
            )
            ->toolbarActions([])
        ;
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
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}
