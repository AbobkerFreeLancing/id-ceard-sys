<?php

namespace App\Filament\Resources\Support\TicketCategories;

use App\Filament\Resources\Support\TicketCategories\Pages\ManageTicketCategories;
use BackedEnum;
use Filament\Actions\ActionGroup;
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
use Packages\Support\Models\TicketCategory;

class TicketCategoryResource extends Resource
{
    protected static ?string $model = TicketCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string
    {
        return __('backend.support_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.category');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.categories');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.categories');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('bedaya.support_tickets_enabled') && auth()->user()->can('support_ticket_categories_management');
    }

    public static function canAccess(): bool
    {
        return config('bedaya.support_tickets_enabled') && auth()->user()->can('support_ticket_categories_management');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('name')->label(__('backend.name'))->required()->maxLength(100),
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
            ])
            ->filters([
                //
            ])
            ->recordActions([
                //
                EditAction::make()->iconButton()->modalWidth('lg'),
                ActionGroup::make([
                    //
                    DeleteAction::make()->disabled(),
                ]),
            ])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTicketCategories::route('/'),
        ];
    }
}
