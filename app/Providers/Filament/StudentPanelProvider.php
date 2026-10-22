<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\StudetPanelLogin;
use App\Filament\Student\Pages\StudentDashboardPage;
use Filament\FontProviders\LocalFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Support\Facades\Blade;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\URL;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class StudentPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('student')
            ->path('student')
            ->authGuard('student')
            ->login(StudetPanelLogin::class)
            ->globalSearch(false)
            ->colors([
                'primary' => Color::Blue,
            ])
            ->font('Almarai-Regular', url: URL::asset('Almarai-Regular-CSS.css'), provider: LocalFontProvider::class)
            ->darkMode(false)
            ->assets([
                Css::make('custom-stylesheet', asset('custom_filament.css')),
                Js::make('dashboard_js', asset('js/dashboard_custom.js')),
            ])
            ->sidebarWidth('250px')
            ->sidebarCollapsibleOnDesktop()
            ->favicon(asset('static/favicon.png'))
            ->brandLogo(fn() => view('filament.student-dashboard-logo'))
            ->brandLogoHeight(50)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/Student/Resources'), for: 'App\Filament\Student\Resources')
            ->discoverPages(in: app_path('Filament/Student/Pages'), for: 'App\Filament\Student\Pages')
            ->pages([StudentDashboardPage::class])
            ->readOnlyRelationManagersOnResourceViewPagesByDefault(false)
            ->discoverWidgets(in: app_path('Filament/Student/Widgets'), for: 'App\Filament\Student\Widgets')
            ->widgets([AccountWidget::class, FilamentInfoWidget::class])
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
            ])
            ->authMiddleware([Authenticate::class])

            ->navigationGroups([
                NavigationGroup::make()->label(__('backend.students_module')),
                NavigationGroup::make()->label(__('backend.financial_accounts')),
                NavigationGroup::make()->label(__('backend.support_module')),
            ]);
    }
}
