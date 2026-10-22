<?php

namespace Packages\Enum;

enum PriorityEnum: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';
    case Urgent = 'urgent';

    public function label(): string
    {
        return match ($this) {
            self::Low => __('backend.priority_low'),
            self::Medium => __('backend.priority_medium'),
            self::High => __('backend.priority_high'),
            self::Urgent => __('backend.priority_urgent'),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Low => 'gray',
            self::Medium => 'info',
            self::High => 'warning',
            self::Urgent => 'danger',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(
                fn($case) => [
                    $case->value => $case->label(),
                ],
            )
            ->toArray();
    }
}
