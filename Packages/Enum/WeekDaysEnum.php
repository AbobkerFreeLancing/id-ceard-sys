<?php

namespace Packages\Enum;

enum WeekDaysEnum: string
{
    case Sat = 'sat';
    case Sun = 'sun';
    case Mon = 'mon';
    case Tue = 'tue';
    case Wed = 'wed';
    case Thu = 'thu';
    case Fri = 'fri';

    public function label(): string
    {
        return match ($this) {
            self::Sat => __('backend.sat'),
            self::Sun => __('backend.sun'),
            self::Mon => __('backend.mon'),
            self::Tue => __('backend.tue'),
            self::Wed => __('backend.wed'),
            self::Thu => __('backend.thu'),
            self::Fri => __('backend.fri'),
        };
    }

    public static function values(): array
    {
        return array_map(
            fn(self $day) => $day->label(),
            self::cases()
        );
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $case) => [$case->value => $case->label()])
            ->toArray();
    }

    public static function academicDays(): array
    {
        return collect(self::cases())
            ->filter(fn(self $day) => $day !== self::Fri)
            ->mapWithKeys(fn(self $day) => [$day->value => $day->label()])
            ->toArray();
    }
}
