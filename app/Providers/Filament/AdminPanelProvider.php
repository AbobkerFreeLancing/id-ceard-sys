<?php

namespace App\Providers\Filament;

use App\Filament\Pages\DashboardPage;
use App\Filament\Pages\DashboardProfilePage;
use App\Filament\Pages\ProfilePasswordUpdate;
use App\Http\Middleware\AdminLocalization;
use App\Livewire\Auth\AdminPanelCustomLogin;
use Packages\Common\Models\Branch;
use Packages\Common\Models\Dev;
use Filament\Actions\Action;
use Filament\FontProviders\LocalFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Livewire\Livewire;
// use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->globalSearch(false)
            ->login(AdminPanelCustomLogin::class)
            ->font('Almarai-Regular', url: URL::asset('Almarai-Regular-CSS.css'), provider: LocalFontProvider::class)
            ->darkMode(true)
            // ->tenant(Branch::class, slugAttribute: 'slug')
            ->assets([
                Css::make('custom-stylesheet', asset('custom_filament.css?v=x55')),
                Js::make('dashboard_js', asset('js/dashboard_custom.js')),
            ])
            ->colors([
                'primary' => Color::hex(dev()?->admin_color_hex ?? '#00a6f4'),
            ])
            ->topNavigation(fn() => !Auth::user()->has_admin_sidebar)
            ->sidebarWidth('260px')
            ->sidebarCollapsibleOnDesktop()
            ->favicon(asset('static/favicon.png'))
            ->brandLogo(fn() => view('filament.logo'))
            ->brandLogoHeight(50)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->pages([DashboardPage::class])
            ->userMenuItems([
                Action::make('profile_item')
                    ->label(__('backend.my_profile'))
                    ->icon('heroicon-s-cog')
                    ->url(fn(): string => DashboardProfilePage::getUrl()),

                Action::make('update_password')
                    ->label(__('backend.update_password'))
                    ->icon('heroicon-s-cog')
                    ->url(fn(): string => ProfilePasswordUpdate::getUrl()),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([])
            ->readOnlyRelationManagersOnResourceViewPagesByDefault(false)
            ->navigationGroups([
                NavigationGroup::make()->label(__('backend.general')),

                NavigationGroup::make()->label(__('backend.cards_management')),

                NavigationGroup::make()->label(__('backend.templates_and_design')),

                NavigationGroup::make()->label(__('backend.cardholders_and_org')),

                NavigationGroup::make()->label(__('backend.verification_security')),

                NavigationGroup::make()->label(__('backend.financial_accounts')),

                NavigationGroup::make()->label(__('backend.users_module')),

                NavigationGroup::make()->label(__('backend.settings')),

                NavigationGroup::make()->label(__('backend.support_module')),

                NavigationGroup::make()->label(__('backend.docs_module')),
            ])
            // ->sidebarFullyCollapsibleOnDesktop()
            ->databaseNotifications(false)
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                AdminLocalization::class,
            ])
            ->authMiddleware([Authenticate::class])
            ->plugins([
                // SpatieTranslatablePlugin::make()->defaultLocales(['ar', 'en']),
            ])
            // ->renderHook('panels::body.start', function (): string {
            //     Livewire::forceAssetInjection();
            //     return '';
            // })
            ->renderHook(
                PanelsRenderHook::USER_MENU_BEFORE,
                fn(): string => Blade::render('filament.top-buttons.quick-add'),
            )
            ->renderHook(
                PanelsRenderHook::USER_MENU_BEFORE,
                fn(): string => Blade::render('filament.top-buttons.settings-menu-dropdown'),
            );
        // ->renderHook(
        //     PanelsRenderHook::FOOTER,
        //     fn(): string => Blade::render('filament.top-buttons.app-footer')
        // );
    }
}
