<?php

namespace App\Filament\Resources\Common\Devs;

use App\Filament\Resources\Common\Devs\Pages\CreateDev;
use App\Filament\Resources\Common\Devs\Pages\EditDev;
use App\Filament\Resources\Common\Devs\Pages\ListDevs;
use App\Filament\Resources\Common\Devs\Schemas\DevForm;
use App\Filament\Resources\Common\Devs\Tables\DevsTable;
use BackedEnum;
use Packages\Common\Models\Dev;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DevResource extends Resource
{
    protected static ?string $model = Dev::class;

    protected static ?string $slug = 'dev';

    protected static bool $isScopedToTenant = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static ?string $recordTitleAttribute = 'id';

    public static function getBreadcrumb(): string
    {
        return '';
    }

    public static function getNavigationGroup(): string
    {
        return 'Dev';
    }

    public static function getLabel(): ?string
    {
        return 'Dev';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Dev';
    }

    public static function getNavigationLabel(): string
    {
        return 'Dev';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return DevForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DevsTable::configure($table);
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
            'index' => ListDevs::route('/'),
            'create' => CreateDev::route('/create'),
            'edit' => EditDev::route('/{record}/edit'),
        ];
    }
}
