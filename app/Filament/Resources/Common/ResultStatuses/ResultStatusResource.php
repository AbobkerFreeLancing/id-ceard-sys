<?php

namespace App\Filament\Resources\Common\ResultStatuses;

use App\Filament\Resources\Common\ResultStatuses\Pages\ManageResultStatuses;
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
use Packages\University\Models\ResultStatus;

class ResultStatusResource extends Resource
{
    protected static ?string $model = ResultStatus::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string
    {
        return __('backend.settings');
    }

    public static function getLabel(): ?string
    {
        return __('backend.result_status');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.result_statuses');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.result_statuses');
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
            TextInput::make('name')->required()->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                //
                TextColumn::make('name')->label(__('backend.name')),
                TextColumn::make('short_description')->label(__('backend.short_description')),
                ToggleColumn::make('is_active')->label(__('backend.is_active')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                //
                EditAction::make()->hidden(),
                DeleteAction::make()->hidden(),
            ])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageResultStatuses::route('/'),
        ];
    }
}
