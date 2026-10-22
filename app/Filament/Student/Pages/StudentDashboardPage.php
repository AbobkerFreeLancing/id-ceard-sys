<?php

namespace App\Filament\Student\Pages;

use App\Filament\Student\Resources\Courses\CourseResource;
use Bedaya\Enum\Profile\UserTypeEnum;
use Bedaya\School\Models\Announcement;
use Filament\Facades\Filament;
use Filament\Widgets\AccountWidget;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\FilamentInfoWidget;

class StudentDashboardPage extends BaseDashboard
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected string $view = 'university::student-dashboard';

    public function getHeading(): string|null
    {
        return null;
    }

    public function mount()
    {
        if (!auth('student')->check()) {
            auth()->logout();
        }

    }

    public static function getNavigationLabel(): string
    {
        return __('backend.home');
    }

    public function getTitle(): string
    {
        return __('backend.dashboard_of_student');
    }

    public function getWidgets(): array
    {
        $widgets = Filament::getWidgets();

        return array_filter($widgets, function ($widget) {
            return $widget !== AccountWidget::class && $widget !== FilamentInfoWidget::class;
        });
    }

    public function getColumns(): int|array
    {
        return [
            'default' => 12,
            'lg' => 12,
        ];
    }
}
