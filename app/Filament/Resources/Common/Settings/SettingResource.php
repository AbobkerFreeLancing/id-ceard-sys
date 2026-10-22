<?php

namespace App\Filament\Resources\Common\Settings;

use App\Filament\Resources\Common\Settings\Pages\EditSetting;
use App\Filament\Resources\Common\Settings\Pages\ListSettings;
use App\Filament\Resources\Common\Settings\Schemas\SettingForm;
use App\Models\Setting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static bool $isScopedToTenant = false;

    protected static ?string $recordTitleAttribute = 'company_name';

    protected static ?string $recordRouteKeyName = 'slug';

    protected static ?int $navigationSort = 10;

    public static function getBreadcrumb(): string
    {
        return '';
    }

    public static function getLabel(): ?string
    {
        return __('backend.settings');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.settings');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return SettingForm::configure($schema);
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
            'index' => ListSettings::route('/'),
            'edit' => EditSetting::route('/{record:slug}/edit'),
        ];
    }
}
