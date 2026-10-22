<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Packages\University\Models\College;

class StudentByCollegeWidget extends ChartWidget
{
    protected static ?int $sort = 8;

    protected function getType(): string
    {
        return 'bar';
    }

    public static function canView(): bool
    {
        return false;
    }

    protected function getColumns(): int|array
    {
        return [
            'default' => 12,
            'xl' => 6,
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return [
            'default' => 12,
            'xl' => 6,
        ];
    }

    public function getHeading(): string
    {
        return __('عدد الطلاب حسب الكلية');
    }

    protected function getFilters(): ?array
    {
        return [];
    }

    protected function getData(): array
    {
        $collegeData = College::withCount('students')->get();

        return [
            'datasets' => [
                [
                    'label' => __('عدد الطلاب'),
                    'data' => $collegeData->pluck('students_count'),
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(201, 203, 207, 0.8)',
                    ],
                    'borderColor' => ['#222'],
                    'borderWidth' => 1,
                ],
            ],

            'labels' => $collegeData->pluck('name'), // استبدل 'name' بحقل اسم الكلية لديك
        ];
    }
}
