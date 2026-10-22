<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class BedayaSettingsPage extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-wrench';
    protected string $view = 'filament.pages.bedaya-settings-page';

    // protected $listeners = ['refreshx' => '$refresh'];

    public static function getNavigationGroup(): string
    {
        return __("backend.settings");
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__("backend.system_config"));
    }

    public function getHeading(): string
    {
        return __('backend.system_config');
    }

    public function getTitle(): string | Htmlable
    {
        return __('backend.system_config');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('settings_management') && false;
    }

    public function mount()
    {
        abort_unless(auth()->user()->can('settings_management'), 403);
    }
}
