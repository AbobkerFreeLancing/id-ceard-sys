<?php

namespace App\Filament\Resources\Common\ActivityLogs;

use App\Filament\Resources\Common\ActivityLogs\Pages\ManageActivityLogs;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Spatie\Activitylog\Models\Activity;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?int $navigationSort = 15;

    public static function getNavigationGroup(): string
    {
        return __('backend.settings');
    }

    public static function getLabel(): ?string
    {
        return __('backend.activity_log');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.activity_log');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.activity_log');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            //
            TextInput::make('id')->required()->maxLength(255),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([TextEntry::make('id')]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                //
                TextColumn::make('id')->searchable(),
                TextColumn::make('description')->label(__('backend.description')),
                TextColumn::make('created_at')->label(__('backend.created_at')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                //
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageActivityLogs::route('/'),
        ];
    }
}
